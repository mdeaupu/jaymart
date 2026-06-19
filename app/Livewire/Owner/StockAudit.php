<?php

namespace App\Livewire\Owner;

use App\Models\AuditLog;
use App\Models\Branches;
use Livewire\Component;
use Livewire\WithPagination;

class StockAudit extends Component
{
    use WithPagination;

    // Properti Filter Dinamis
    public $search = '';
    public $filterBranch = '';
    public $filterAction = '';

    // Reset halaman pagination jika filter berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingFilterBranch()
    {
        $this->resetPage();
    }
    public function updatingFilterAction()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Mengambil data log audit dengan filter spesifik owner
        $logs = AuditLog::with(['branch', 'user'])
            ->when($this->filterBranch, function ($query) {
                $query->where('branch_id', $this->filterBranch);
            })
            ->when($this->filterAction, function ($query) {
                $query->where('action', $this->filterAction);
            })
            ->when($this->search, function ($query) {
                $query->where('description', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(15);

        // Mengambil daftar cabang untuk dropdown filter
        $branches = Branches::all();

        // Ambil tipe aksi unik yang terdaftar di DB untuk opsi filter
        $availableActions = AuditLog::select('action')->distinct()->pluck('action');

        return view('livewire.owner.stock-audit', compact('logs', 'branches', 'availableActions'))
            ->layout('layouts.app');
    }
}