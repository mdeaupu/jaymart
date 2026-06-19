<?php

namespace App\Livewire\Warehouse;

use App\Models\StockAdjustments;
use App\Models\StockLogs;
use App\Models\Stocks;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        // Ambil data branch akun gudang yang sedang aktif melihat dashboard
        $branchId = auth()->user()->branch_id;

        $stats = [
            'total_items' => Stocks::where('branch_id', $branchId)->count(),
            'low_stock_count' => Stocks::where('branch_id', $branchId)->whereRaw('quantity <= low_stock_threshold')->count(),
            'incoming_today' => StockLogs::where('branch_id', $branchId)
                ->where('type', 'in')
                ->whereDate('created_at', today())
                ->sum('amount'),
            'pending_adjustments' => StockAdjustments::where('branch_id', $branchId)->where('status', 'pending')->count(),
        ];

        $lowStockItems = Stocks::with('product')
            ->where('branch_id', $branchId)
            ->whereRaw('quantity <= low_stock_threshold')
            ->orderBy('quantity', 'asc')
            ->take(5)
            ->get();

        $recentActivities = StockLogs::with(['product', 'user'])
            ->where('branch_id', $branchId)
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