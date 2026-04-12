<?php

namespace App\Livewire\Manager;

use App\Models\Products;
use App\Models\StockLogs;
use App\Models\StockPurchase;
use App\Models\Stocks;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class StockPurchaseCreate extends Component
{
    use WithFileUploads;

    public $supplier_id, $product_id, $quantity, $total_price, $purchase_date, $invoice_number, $invoice_file;

    public function submit()
    {
        $this->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric',
            'purchase_date' => 'required|date',
            'invoice_file' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () {
            $branch_id = auth()->user()->branch_id;

            $purchase = StockPurchase::create([
                'branch_id' => $branch_id,
                'supplier_id' => $this->supplier_id,
                'product_id' => $this->product_id,
                'user_id' => auth()->id(),
                'quantity' => $this->quantity,
                'total_price' => $this->total_price,
                'invoice_number' => $this->invoice_number,
                'purchase_date' => $this->purchase_date,
                'status' => 'pending',
            ]);

            if ($this->invoice_file) {
                $purchase->addMedia($this->invoice_file)->toMediaCollection('invoices');
            }

            $stock = Stocks::firstOrCreate(
                ['branch_id' => $branch_id, 'product_id' => $this->product_id],
                ['quantity' => 0]
            );
            $stock->increment('quantity', $this->quantity);

            StockLogs::create([
                'branch_id' => $branch_id,
                'product_id' => $this->product_id,
                'user_id' => auth()->id(),
                'type' => 'in',
                'amount' => $this->quantity,
                'reason' => "Pembelian dari Supplier (Inv: {$this->invoice_number})",
            ]);
        });

        session()->flash('message', 'Pembelian berhasil dicatat dan stok telah diperbarui.');
        return redirect()->route('manager.dashboard');
    }

    public function render()
    {
        return view('livewire.manager.stock-purchase-create', [
            'suppliers' => Supplier::orderBy('name')->get(),
            'products' => Products::orderBy('name')->get(),
        ])->layout('layouts.app');
    }
}
