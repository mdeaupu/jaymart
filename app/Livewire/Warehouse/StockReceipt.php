<?php

namespace App\Livewire\Warehouse;

use App\Models\Stock;
use App\Models\StockLog;
use App\Models\StockLogs;
use App\Models\StockPurchase;
use App\Models\StockPurchaseDetail;
use App\Models\Stocks;
use App\Models\AuditLog; // <--- TAMBAHKAN IMPORT
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class StockReceipt extends Component
{
    use WithPagination;

    public $received_items = [];
    public $selected_purchase = null;

    protected $rules = [
        'received_items' => 'required|array',
        'received_items.*' => 'required|integer|min:0',
    ];

    protected $validationAttributes = [
        'received_items.*' => 'Jumlah barang diterima',
    ];

    public function startVerification($purchaseId)
    {
        $this->selected_purchase = StockPurchase::with(['details.product', 'supplier', 'branch'])
            ->where('status', 'approved')
            ->findOrFail($purchaseId);

        foreach ($this->selected_purchase->details as $detail) {
            $this->received_items[$detail->id] = $detail->qty_ordered;
        }
    }

    public function cancelVerification()
    {
        $this->selected_purchase = null;
        $this->received_items = [];
    }

    public function saveReceipt()
    {
        $this->validate();

        DB::transaction(function () {
            $purchase = StockPurchase::lockForUpdate()->findOrFail($this->selected_purchase->id);

            if ($purchase->status !== 'approved') {
                return;
            }

            foreach ($this->received_items as $detailId => $qtyReceived) {
                $detail = StockPurchaseDetail::findOrFail($detailId);

                $detail->update([
                    'qty_received' => $qtyReceived,
                ]);

                if ($qtyReceived > 0) {
                    $stock = Stocks::where('branch_id', $purchase->branch_id)
                        ->where('product_id', $detail->product_id)
                        ->first();

                    if ($stock) {
                        $stock->increment('quantity', $qtyReceived);
                    } else {
                        Stocks::create([
                            'branch_id' => $purchase->branch_id,
                            'product_id' => $detail->product_id,
                            'quantity' => $qtyReceived,
                            'low_stock_threshold' => 10,
                        ]);
                    }

                    StockLogs::create([
                        'branch_id' => $purchase->branch_id,
                        'product_id' => $detail->product_id,
                        'user_id' => auth()->id(),
                        'type' => 'in',
                        'amount' => $qtyReceived,
                        'reason' => "Penerimaan barang dari Supplier via PO: {$purchase->po_number}",
                    ]);
                }
            }

            $purchase->update([
                'status' => 'received',
                'received_by' => auth()->id()
            ]);

            // 📝 TAMBAHKAN AUDIT LOG PENERIMAAN PO
            AuditLog::create([
                'branch_id' => $purchase->branch_id,
                'user_id' => auth()->id(),
                'action' => 'RECEIVE_PO',
                'description' => "Menerima dan memverifikasi fisik muatan barang masuk dari PO nomor #{$purchase->po_number}."
            ]);
        });

        session()->flash('message', 'Fisik barang berhasil diverifikasi! Stok sistem cabang telah bertambah.');
        $this->cancelVerification();
    }

    public function render()
    {
        $incomingPurchases = StockPurchase::with(['supplier', 'branch', 'details.product'])
            ->where('status', 'approved')
            ->latest()
            ->paginate(10);

        return view('livewire.warehouse.stock-receipt', [
            'incomingPurchases' => $incomingPurchases
        ])->layout('layouts.app');
    }
}