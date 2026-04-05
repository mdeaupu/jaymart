<?php

namespace App\Livewire\Manager;

use App\Models\Stocks;
use App\Models\Transactions;
use App\Models\TransactionsDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $today = Carbon::today();

        $managerBranchId = auth()->user()->branch_id;

        $totalOmzet = Transactions::where('branch_id', $managerBranchId)
            ->whereDate('created_at', $today)
            ->sum('total_price');

        $totalTransactions = Transactions::where('branch_id', $managerBranchId)
            ->whereDate('created_at', $today)
            ->count();

        $lowStocks = Stocks::with('product')
            ->where('branch_id', $managerBranchId)
            ->whereColumn('quantity', '<=', 'low_stock_threshold')
            ->get();

        $bestSellers = TransactionsDetail::select('product_id', DB::raw('SUM(qty) as total_sold'))
            ->whereHas('transaction', function ($q) use ($today, $managerBranchId) {
                $q->where('branch_id', $managerBranchId)
                    ->whereDate('created_at', $today);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->with('product')
            ->get();

        return view('livewire.manager.dashboard', compact(
            'totalOmzet',
            'totalTransactions',
            'lowStocks',
            'bestSellers'
        ))->layout('layouts.app');
    }
}
