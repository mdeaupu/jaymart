<?php

namespace App\Livewire\Supervisor;

use Livewire\Component;
use App\Models\Transactions;
use Carbon\Carbon;

class RealtimeMonitoring extends Component
{
    public function render()
    {
        $branchId = auth()->user()->branch_id;
        $today = Carbon::today();

        $transactions = Transactions::with(['user', 'branch'])
            ->where('branch_id', $branchId)
            ->latest()
            ->take(10)
            ->get();

        // 🔒 KUNCI FILTER CABANG AGAR TIDAK SALING INTIP OMSET ANTAR CABANG
        $todayCount = Transactions::where('branch_id', $branchId)
            ->whereDate('created_at', $today)
            ->count();

        $todayRevenue = Transactions::where('branch_id', $branchId)
            ->whereDate('created_at', $today)
            ->sum('total_price');

        $lastTransaction = Transactions::where('branch_id', $branchId)
            ->latest()
            ->first();

        return view('livewire.supervisor.realtime-monitoring', [
            'transactions' => $transactions,
            'todayCount' => $todayCount,
            'todayRevenue' => $todayRevenue,
            'lastTransactionTime' => $lastTransaction?->created_at?->format('H:i:s')
        ]);
    }
}