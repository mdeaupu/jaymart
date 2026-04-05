<?php

namespace App\Livewire\Inventory;

use App\Models\StockAdjustments;
use App\Models\StockLogs;
use App\Models\Stocks;
use Livewire\Component;
use Livewire\WithPagination;

class StockAdjustmentIndex extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.inventory.stock-adjustment-index', [
            'adjustments' => StockAdjustments::with(['branch', 'product'])
                ->where('status', 'pending')
                ->latest()
                ->paginate(10)
        ])->layout('layouts.app'); // Memastikan layout terpanggil
    }

    public function approveAdjustment($id)
    {
        $adj = StockAdjustments::findOrFail($id);

        // Pastikan hanya data pending yang bisa di-approve
        if ($adj->status !== 'pending') {
            session()->flash('error', 'Permintaan ini sudah diproses.');
            return;
        }

        // 1. Update Stok Utama (Gunakan increment untuk keamanan data)
        $stock = Stocks::where('branch_id', $adj->branch_id)
            ->where('product_id', $adj->product_id)
            ->first();

        if ($stock) {
            $stock->increment('quantity', $adj->adjustment_amount);
        }

        // 2. Catat ke Stock Log (Audit Trail)
        StockLogs::create([
            'branch_id' => $adj->branch_id,
            'product_id' => $adj->product_id,
            'user_id' => auth()->id(), // Mencatat siapa yang menyetujui (Owner/Pak Jayusman)
            'type' => $adj->adjustment_amount > 0 ? 'in' : 'out',
            'amount' => abs($adj->adjustment_amount),
            'reason' => "Adjustment Approved: " . $adj->reason,
        ]);

        // 3. Update status adjustment
        $adj->update([
            'status' => 'approved',
            'approved_by' => auth()->id()
        ]);

        session()->flash('message', 'Stok berhasil diperbarui dan dicatat dalam log.');
    }

    public function rejectAdjustment($id)
    {
        $adj = StockAdjustments::findOrFail($id);

        if ($adj->status !== 'pending') {
            session()->flash('error', 'Permintaan ini sudah diproses.');
            return;
        }

        $adj->update([
            'status' => 'rejected',
            'approved_by' => auth()->id()
        ]);

        session()->flash('message', 'Permintaan ditolak.');
    }
}
