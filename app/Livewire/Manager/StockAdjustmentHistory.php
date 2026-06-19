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
        $user = auth()->user();

        $histories = StockAdjustments::with(['product', 'user', 'approver'])
            ->where('branch_id', $user->branch_id)
            ->latest()
            ->paginate(10);

        return view('livewire.manager.stock-adjustment-history', [
            'histories' => $histories
        ])->layout('layouts.app');
    }
}