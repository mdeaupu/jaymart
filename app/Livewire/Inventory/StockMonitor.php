<?php

namespace App\Livewire\Inventory;

use App\Models\Branches;
use App\Models\Stocks;
use Livewire\Component;
use Livewire\WithPagination;

class StockMonitor extends Component
{
    use WithPagination;

    public $search = '';
    public $branch_id = '';

    public function render()
    {
        $stocks = Stocks::with(['product', 'branch'])
            ->when($this->branch_id, fn($q) => $q->where('branch_id', $this->branch_id))
            ->whereHas('product', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->latest()
            ->paginate(10);

        return view('livewire.inventory.stock-monitor', [
            'stocks' => $stocks,
            'branches' => Branches::all()
        ])->layout('layouts.app');
        ;
    }
}
