<?php

namespace App\Livewire\Supervisor;

use Livewire\Component;
use App\Models\ApprovalRequest;

class VoidApproval extends Component
{
    public function approve($id)
    {
        $req = ApprovalRequest::findOrFail($id);

        $req->update([
            'status' => 'approved',
            'approved_by' => auth()->id()
        ]);

        // hapus transaksi (void)
        $req->transaction?->delete();

        session()->flash('message', 'Void disetujui');
    }

    public function reject($id)
    {
        $req = ApprovalRequest::findOrFail($id);

        $req->update([
            'status' => 'rejected',
            'approved_by' => auth()->id()
        ]);

        session()->flash('message', 'Void ditolak');
    }

    public function render()
    {
        $requests = ApprovalRequest::with(['transaction', 'requester'])
            ->where('type', 'void')
            ->where('status', 'pending')
            ->latest()
            ->get();
            
        return view('livewire.supervisor.void-approval', compact('requests'));
    }
}