<?php

namespace App\Livewire\Warehouse;

use App\Models\StockAdjustments;
use App\Models\StockLogs;
use App\Models\Stocks;
use Livewire\Component;
use App\Models\Stock;
use App\Models\StockLog;
use App\Models\StockAdjustment;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public function render()
    {

        $stats = [
            'total_items' => Stocks::count(),
            'low_stock_count' => Stocks::whereRaw('quantity <= low_stock_threshold')->count(),
            'incoming_today' => StockLogs::where('type', 'in')
                ->whereDate('created_at', today())
                ->sum('amount'),
            'pending_adjustments' => StockAdjustments::where('status', 'pending')->count(),
        ];

        $lowStockItems = Stocks::with('product')
            ->whereRaw('quantity <= low_stock_threshold')
            ->orderBy('quantity', 'asc')
            ->take(5)
            ->get();

        $recentActivities = StockLogs::with(['product', 'user'])
            ->latest()
            ->take(8)
            ->get();

        return view('livewire.warehouse.dashboard', [
            'stats' => $stats,
            'lowStockItems' => $lowStockItems,
            'recentActivities' => $recentActivities,
        ])->layout('layouts.app');
    }
}