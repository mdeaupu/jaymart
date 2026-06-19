<?php

namespace App\Livewire\Owner;

use App\Models\Branches;
use App\Models\Stocks;
use App\Models\Transactions;
use App\Models\CashierCorrections;
use App\Models\AuditLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $filterPeriod = 'today'; // Pengendali filter waktu jarak jauh bagi Owner

    public function render()
    {
        $dateRange = match ($this->filterPeriod) {
            'today' => [Carbon::today(), Carbon::now()],
            'week' => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
            'month' => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
            default => [Carbon::today(), Carbon::now()]
        };

        // 💰 1. KONSOLIDASI FINANSIAL MULTI-CABANG (Bukan Cuma 1 Toko)
        $totalRevenueAllBranch = Transactions::whereBetween('created_at', $dateRange)->sum('total_price');
        $totalTransactionsAllBranch = Transactions::whereBetween('created_at', $dateRange)->count();

        // 📉 2. PELAKU FRAUD CONTROL: Menghitung Berapa Omzet yang Hilang dari Void/Koreksi di 5 Cabang
        $totalLossFromCorrections = CashierCorrections::where('status', 'approved')
            ->whereBetween('updated_at', $dateRange)
            ->sum('financial_impact');

        // 📊 3. KOMPARASI BISNIS: Bandingkan Pendapatan Antar 5 Cabang (Analisis Kompetitif)
        $branchPerformances = Branches::all()->map(function ($branch) use ($dateRange) {
            $revenue = Transactions::where('branch_id', $branch->id)
                ->whereBetween('created_at', $dateRange)
                ->sum('total_price') ?: 0;

            $correctionsCount = CashierCorrections::where('branch_id', $branch->id)
                ->where('status', 'approved')
                ->whereBetween('updated_at', $dateRange)
                ->count();

            $correctionsValue = CashierCorrections::where('branch_id', $branch->id)
                ->where('status', 'approved')
                ->whereBetween('updated_at', $dateRange)
                ->sum('financial_impact') ?: 0;

            return [
                'name' => $branch->name,
                'revenue' => $revenue,
                'fraud_risk_count' => $correctionsCount,
                'fraud_risk_value' => $correctionsValue,
            ];
        });

        // 🚨 4. INVESTIGASI STOK KRITIS (Top 10 Barang Paling Menipis di Seluruh Cabang)
        $criticalStocks = Stocks::with(['product', 'branch'])
            ->whereColumn('quantity', '<=', 'low_stock_threshold')
            ->orderBy('quantity', 'asc')
            ->limit(10)
            ->get();

        // 🕵️‍♂️ 5. AUDIT LOG FRAUD TRACKER (Pantau Siapa Melakukan Apa di Lapangan Secara Real-time)
        $recentAuditLogs = AuditLog::with(['branch', 'user'])
            ->whereIn('action', ['APPROVE', 'REJECT', 'APPROVE_MANAGER', 'ESCALATE'])
            ->latest()
            ->limit(8)
            ->get();

        return view('livewire.owner.dashboard', [
            'totalRevenueAllBranch' => $totalRevenueAllBranch,
            'totalTransactionsAllBranch' => $totalTransactionsAllBranch,
            'totalLossFromCorrections' => $totalLossFromCorrections,
            'branchPerformances' => $branchPerformances,
            'criticalStocks' => $criticalStocks,
            'recentAuditLogs' => $recentAuditLogs
        ])->layout('layouts.app');
    }
}