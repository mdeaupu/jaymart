<?php

namespace App\Livewire\Owner;

use App\Models\StockLogs;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ApprovalRequest;
use App\Models\Stock;

class StockAudit extends Component
{
    use WithPagination;
    public $product_id;
    public $real_stock;

    public function render()
    {
        return view('livewire.owner.stock-audit', [
            'logs' => StockLogs::with(['product', 'branch', 'user'])
                ->latest()
                ->paginate(11)
        ])->layout('layouts.app');
        ;
    }

    public function submitAudit()
    {
        $stock = Stock::where('product_id', $this->product_id)->first();

        if (!$stock) return;

        // kirim ke approval, BUKAN update langsung
        ApprovalRequest::create([
            'type' => 'adjustment',
            'status' => 'pending',
            'requested_by' => auth()->id(),
            'data' => json_encode([
                'product_id' => $this->product_id,
                'old_stock' => $stock->jumlah,
                'real_stock' => $this->real_stock
            ])
        ]);

        session()->flash('message', 'Pengajuan stock berhasil, menunggu approval');
    }
}
