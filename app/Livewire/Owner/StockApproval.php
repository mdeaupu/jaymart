<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\ApprovalRequest;

class StockApproval extends Component
{
    public function approve($id)
    {
        $req = ApprovalRequest::find($id);

        // sementara: cuma ubah status dulu
        $req->update([
            'status' => 'approved',
            'approved_by' => auth()->id()
        ]);
    }

    public function reject($id)
    {
        ApprovalRequest::where('id', $id)
            ->update(['status' => 'rejected']);
    }

    public function render()
    {
        return view('livewire.inventory.stock-approval', [
            'requests' => ApprovalRequest::where('status', 'pending')->get()
        ])->layout('layouts.app');
    }
}