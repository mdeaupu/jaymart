<?php

namespace App\Livewire\Warehouse;

use App\Models\StockAdjustments;
use App\Models\Stocks;
use Livewire\Component;

class BlindOpname extends Component
{
    public $counts = [];

    public function mount()
    {
        $stocks = Stocks::with('product')->get();
        foreach ($stocks as $stock) {
            $this->counts[$stock->id] = '';
        }
    }

    public function submit()
    {
        foreach ($this->counts as $stockId => $countedQty) {
            if ($countedQty === '' || $countedQty === null)
                continue;

            $stock = Stocks::find($stockId);
            $adjustmentAmount = $countedQty - $stock->quantity;

            if ($adjustmentAmount != 0) {
                StockAdjustments::create([
                    'product_id' => $stock->product_id,
                    'user_id' => auth()->id(),
                    'old_quantity' => $stock->quantity,
                    'new_quantity' => $countedQty,
                    'adjustment_amount' => $adjustmentAmount,
                    'reason' => 'Blind Stock Opname',
                    'status' => 'pending'
                ]);
            }
        }

        $this->counts = [];
        session()->flash('message', 'Hasil opname berhasil disubmit dan menunggu approval Manager.');
    }

    public function render()
    {
        return view('livewire.warehouse.blind-opname', [
            'stocks' => Stocks::with('product')->get()
        ])->layout('layouts.app');
    }
}
