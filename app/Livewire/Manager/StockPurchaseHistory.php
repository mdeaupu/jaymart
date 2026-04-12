<?php

namespace App\Livewire\Manager;

use App\Models\StockPurchase;
use Livewire\Component;
use Livewire\WithPagination;

class StockPurchaseHistory extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.manager.stock-purchase-history', [
            'purchases' => StockPurchase::with(['product', 'supplier'])
                ->where('user_id', auth()->id())
                ->latest()
                ->paginate(10)
        ])->layout('layouts.app');
    }
}
