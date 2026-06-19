<?php

namespace App\Livewire\Supervisor;

use App\Models\StockAdjustments;
use Livewire\Component;
use Livewire\WithPagination;

class AdjustmentHistory extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    // Reset pagination jika user melakukan searching
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();

        $histories = StockAdjustments::with(['product', 'user', 'approver'])
            ->where('branch_id', $user->branch_id) // KUNCI: Hanya cabang si supervisor
            ->where('reason', 'like', '%Blind Stock Opname%') // Fokus pada riwayat opname lapangan
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->search, function ($query) {
                $query->whereHas('product', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('sku', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.supervisor.adjustment-history', [
            'histories' => $histories
        ])->layout('layouts.app');
    }
}