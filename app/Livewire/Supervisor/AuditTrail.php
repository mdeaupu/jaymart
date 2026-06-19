<?php

namespace App\Livewire\Supervisor;

use Livewire\Component;
use App\Models\AuditLog;
use Livewire\WithPagination;

class AuditTrail extends Component
{
    use WithPagination;

    // Memastikan polling berjalan aman tanpa merusak posisi pagination halaman
    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $user = auth()->user();

        // Kunci data berdasarkan branch_id Supervisor yang sedang login
        $logs = AuditLog::with(['user', 'branch'])
            ->where('branch_id', $user->branch_id)
            ->latest()
            ->paginate(15);

        return view('livewire.supervisor.audit-trail', [
            'logs' => $logs
        ])->layout('layouts.app');
    }
}