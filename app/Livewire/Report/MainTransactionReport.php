<?php

namespace App\Livewire\Report;

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
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }


    // app/Livewire/Report/MainTransactionReport.php
    public function render()
    {
        $query = Transactions::with(['branch', 'user'])
            ->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']);

        if ($this->branchId) {
            $query->where('branch_id', $this->branchId);
        }

        return view('livewire.report.main-transaction-report', [
            'transactions' => $query->latest()->paginate(10),
            'branches' => Branches::all(),
            'stats' => [
                'total_revenue' => $query->sum('total_price'),
                'total_transactions' => $query->count(),
                'avg_transaction' => $query->avg('total_price') ?? 0,
            ]
        ]);
    }
}
