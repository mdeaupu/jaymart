<?php

namespace App\Livewire\Manager;

use App\Models\Transactions;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FinancialSummary extends Component
{
    public $filterDate;

    public function mount()
    {
        $this->filterDate = Carbon::today()->format('Y-m-d');
    }

    public function render()
    {
        $managerBranchId = auth()->user()->branch_id;

        $cashierSummaries = Transactions::select(
            'user_id',
            DB::raw('SUM(total_price) as total_deposit'),
            DB::raw('COUNT(id) as transaction_count')
        )
            ->where('branch_id', $managerBranchId)
            ->whereDate('created_at', $this->filterDate)
            ->groupBy('user_id')
            ->with('user')
            ->get();

        return view('livewire.manager.financial-summary', compact('cashierSummaries'))
            ->layout('layouts.app');
    }
}
