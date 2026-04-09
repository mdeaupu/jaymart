<?php

namespace App\Livewire\Supervisor;

use Livewire\Component;
use App\Models\Transactions;
use Carbon\Carbon;

class RealtimeMonitoring extends Component
{

    public function render()
    {
        $transactions = Transactions::with(['user', 'branch'])
            ->latest()
            ->take(10)
            ->get();

        $today = Carbon::today();

        $todayCount = Transactions::whereDate('created_at', $today)->count();

        $todayRevenue = Transactions::whereDate('created_at', $today)->sum('total_price');

        $lastTransaction = Transactions::latest()->first();

        return view('livewire.supervisor.realtime-monitoring', [
            'transactions' => $transactions,
            'todayCount' => $todayCount,
            'todayRevenue' => $todayRevenue,
            'lastTransactionTime' => $lastTransaction?->created_at?->format('H:i:s')
        ]);
    }
}