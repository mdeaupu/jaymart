<?php

namespace App\Livewire\Cashier;

use Livewire\Component;
use App\Models\Transactions;

class Report extends Component
{
    public $shift = 'Pagi';

   public function render()
    {
        $transactions = Transactions::where('user_id', auth()->id())
            ->whereDate('created_at', today())
            ->where('shift', $this->shift)
            ->latest()
            ->get();

        return view('livewire.cashier.report', [
            'transactions' => $transactions,
            'total' => $transactions->sum('total_price'),
            'count' => $transactions->count(),
        ])->layout('layouts.app');
    }
    
}
