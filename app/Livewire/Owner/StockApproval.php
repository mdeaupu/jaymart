<?php

namespace App\Livewire\Owner;

use App\Models\StockLogs;
use App\Models\StockPurchase;
use App\Models\Stocks;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class StockApproval extends Component
{
    use WithPagination;

    public function approvePurchase($id)
    {
        DB::transaction(function () use ($id) {
            $purchase = StockPurchase::findOrFail($id);

            $purchase->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
            ]);

            $stock = Stocks::firstOrCreate(
                ['branch_id' => $purchase->branch_id, 'product_id' => $purchase->product_id],
                ['quantity' => 0]
            );
            $stock->increment('quantity', $purchase->quantity);

            StockLogs::create([
                'branch_id' => $purchase->branch_id,
                'product_id' => $purchase->product_id,
                'user_id' => $purchase->user_id,
                'type' => 'in',
                'amount' => $purchase->quantity,
                'reason' => "Pembelian Disetujui (Inv: {$purchase->invoice_number})",
            ]);
        });

        session()->flash('message', 'Pembelian stok berhasil disetujui.');
    }

    public function rejectPurchase($id)
    {
        $purchase = StockPurchase::findOrFail($id);
        $purchase->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
        ]);

        session()->flash('message', 'Pembelian stok telah ditolak.');
    }

    public function render()
    {
        return view('livewire.owner.stock-approval', [
            'purchases' => StockPurchase::with(['product', 'supplier', 'branch'])
                ->where('status', 'pending')
                ->latest()
                ->paginate(10),
        ])->layout('layouts.app');
    }
}
