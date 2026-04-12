<?php

namespace App\Livewire\Manager;

use App\Models\StockAdjustments;
use Livewire\Component;
use Livewire\WithPagination;

class StockAdjustmentHistory extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.manager.stock-adjustment-history', [
            'histories' => StockAdjustments::with(['product'])
                ->where('user_id', auth()->id())
                ->latest()
                ->paginate(10)
        ])->layout('layouts.app');
    }
}
