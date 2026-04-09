<?php

namespace App\Livewire\Warehouse;

use App\Models\StockLogs;
use App\Models\Stocks;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DamagedExpired extends Component
{
    public $product_id, $quantity, $type = 'expired', $reason;

    public function save()
    {
        $this->validate([
            'product_id' => 'required|exists:stocks,product_id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:expired,out',
            'reason' => 'required|string|max:255',
        ]);

        DB::transaction(function () {
            $stock = Stocks::where('product_id', $this->product_id)->first();

            if ($stock->quantity >= $this->quantity) {
                $stock->decrement('quantity', $this->quantity);

                StockLogs::create([
                    'product_id' => $this->product_id,
                    'user_id' => auth()->id(),
                    'type' => $this->type,
                    'amount' => $this->quantity,
                    'reason' => $this->reason,
                ]);

                session()->flash('message', 'Log kerusakan/kedaluwarsa berhasil dicatat.');
            } else {
                session()->flash('error', 'Stok tidak mencukupi untuk dikurangi.');
            }
        });

        $this->reset(['quantity', 'reason']);
    }

    public function render()
    {
        return view('livewire.warehouse.damaged-expired', [
            'stocks' => Stocks::with('product')->get()
        ])->layout('layouts.app');
    }
}
