<?php

namespace App\Livewire\Dashboard;

use App\Models\Branches;
use App\Models\Stocks;
use App\Models\Transactions;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OwnerDashboard extends Component
{
    public function render()
    {
        $income = [
            'daily' => Transactions::whereDate('created_at', today())->sum('total_price'),
            'weekly' => Transactions::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_price'),
            'monthly' => Transactions::whereMonth('created_at', now()->month)->sum('total_price'),
        ];

        $criticalStocks = Stocks::with(['product', 'branch'])
            ->whereColumn('quantity', '<=', 'low_stock_threshold')
            ->orderBy('quantity', 'asc')
            ->limit(10)
            ->get();

        $chartData = Branches::all()->map(function ($branch) {
            return [
                'name' => $branch->name,
                'total_sales' => Transactions::where('branch_id', $branch->id)->sum('total_price') ?: 0
            ];
        });
        $chartData = collect($chartData);

        return view('livewire.dashboard.owner-dashboard', [
            'income' => $income,
            'criticalStocks' => $criticalStocks,
            'chartData' => $chartData
        ])->layout('layouts.app');
    }
}
