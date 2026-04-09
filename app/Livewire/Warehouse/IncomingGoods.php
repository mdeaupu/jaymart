<?php

namespace App\Livewire\Warehouse;

use App\Models\Products;
use App\Models\StockLogs;
use App\Models\Stocks;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class IncomingGoods extends Component
{
    public $product_id, $supplier_id, $quantity, $notes;

    public function save()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () {
            $stock = Stocks::firstOrCreate(
                ['product_id' => $this->product_id, 'branch_id' => auth()->user()->branch_id],
                ['quantity' => 0]
            );

            $stock->increment('quantity', $this->quantity);

            StockLogs::create([
                'product_id' => $this->product_id,
                'user_id' => auth()->id(),
                'type' => 'in',
                'amount' => $this->quantity,
                'reason' => 'Barang masuk dari supplier. Catatan: ' . $this->notes,
            ]);
        });

        $this->reset(['product_id', 'supplier_id', 'quantity', 'notes']);
        session()->flash('message', 'Barang masuk berhasil dicatat.');
    }

    public function render()
    {
        return view('livewire.warehouse.incoming-goods', [
            'products' => Products::all(),
        ])->layout('layouts.app');
    }
}
