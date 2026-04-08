<?php

namespace App\Livewire\Cashier;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.cashier.dashboard')
            ->layout('layouts.app');
    }
}