<?php

namespace App\Livewire\Inventory;

use App\Models\StockLogs;
use Livewire\Component;
use Livewire\WithPagination;

class StockAudit extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.inventory.stock-audit', [
            'logs' => StockLogs::with(['product', 'branch', 'user'])
                ->latest()
                ->paginate(11)
        ])->layout('layouts.app');
        ;
    }
}
