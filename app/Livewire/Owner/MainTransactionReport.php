<?php

namespace App\Livewire\Owner;

use App\Models\Branches;
use App\Models\Transactions;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class MainTransactionReport extends Component
{
    use WithPagination;

    public $startDate;
    public $endDate;
    public $branchId = '';

    #[Layout('layouts.app')]
    public function mount()
    {
        if (!Auth::user()->hasRole('owner')) {
            abort(403, 'Hanya Owner yang dapat mengakses halaman ini.');
        }

        $this->startDate = now()->subDays(30)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function render()
    {
        $query = Transactions::with(['branch', 'user'])
            ->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']);

        if ($this->branchId) {
            $query->where('branch_id', $this->branchId);
        }

        $stats = [
            'total_revenue' => (clone $query)->sum('total_price'),
            'total_transactions' => (clone $query)->count(),
            'avg_transaction' => (clone $query)->avg('total_price') ?? 0,
        ];

        $transactions = $query->latest()->paginate(11);

        return view('livewire.owner.main-transaction-report', [
            'transactions' => $transactions,
            'branches' => Branches::all(),
            'stats' => $stats
        ]);
    }

    public function updatedBranchId()
    {
        $this->resetPage();
    }
    public function updatedStartDate()
    {
        $this->resetPage();
    }
    public function updatedEndDate()
    {
        $this->resetPage();
    }
}
