<?php

namespace App\Livewire;

use App\Models\Transactions;
use Livewire\Component;

class OwnerDashboard extends Component
{
    public function render()
    {
        return view('livewire.pages.owner.dashboard')
            ->layout('layouts.app');
    }
}
