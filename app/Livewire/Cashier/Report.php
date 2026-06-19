<?php

namespace App\Livewire\Cashier;

use Livewire\Component;
use App\Models\Transactions;
use Carbon\Carbon; // <--- Pastikan import Carbon

class Report extends Component
{
    public $shift; // Hapus nilai 'Pagi' di sini agar diatur lewat mount()

    public function mount()
    {
        $currentHour = now()->hour;

        if ($currentHour >= 6 && $currentHour < 14) {
            $this->shift = 'Pagi';
        } elseif ($currentHour >= 14 && $currentHour < 18) {
            $this->shift = 'Siang';
        } else {
            $this->shift = 'Malam';
        }
    }

    public function render()
    {
        $branchId = auth()->user()->branch_id;

        $transactions = Transactions::where('user_id', auth()->id())
            ->where('branch_id', $branchId)
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