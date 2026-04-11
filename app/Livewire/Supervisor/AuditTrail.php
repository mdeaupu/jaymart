<?php 

namespace App\Livewire\Supervisor;

use Livewire\Component;
use App\Models\AuditLog;

class AuditTrail extends Component
{
    public function render()
    {
        $logs = AuditLog::with(['user','branch'])
            ->latest()
            ->limit(50)
            ->get();

        return view('livewire.supervisor.audit-trail', [
            'logs' => $logs
        ]);
    }
}

?>