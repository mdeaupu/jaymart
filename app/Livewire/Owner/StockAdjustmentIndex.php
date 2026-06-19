<?php

namespace App\Livewire\Owner;

use App\Models\StockAdjustments;
use App\Models\StockLogs;
use App\Models\Stocks;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class StockAdjustmentIndex extends Component
{
    use WithPagination;

    public function approveAdjustment($id)
    {
        DB::transaction(function () use ($id) {
            $adj = StockAdjustments::lockForUpdate()->findOrFail($id);

            if ($adj->status !== 'escalated_to_owner') {
                session()->flash('error', 'Permintaan ini tidak dalam status otorisasi Owner.');
                return;
            }

            $stock = Stocks::where('branch_id', $adj->branch_id)
                ->where('product_id', $adj->product_id)
                ->first();

            if ($stock) {
                $stock->update(['quantity' => $adj->new_quantity]);
            }

            StockLogs::create([
                'branch_id' => $adj->branch_id,
                'product_id' => $adj->product_id,
                'user_id' => $adj->user_id,
                'type' => 'adjustment',
                'amount' => $adj->adjustment_amount,
                'reason' => "Otorisasi Mutlak Owner: " . $adj->reason,
            ]);

            $adj->update([
                'status' => 'approved',
                'approved_by' => auth()->id()
            ]);

            session()->flash('message', 'Otorisasi pemutihan disetujui. Database server pusat berhasil diperbarui.');
        });
    }

    public function rejectAdjustment($id)
    {
        $adj = StockAdjustments::findOrFail($id);

        if ($adj->status !== 'escalated_to_owner') {
            session()->flash('error', 'Permintaan ini tidak dalam status otorisasi Owner.');
            return;
        }

        $adj->update([
            'status' => 'rejected',
            'approved_by' => auth()->id()
        ]);

        session()->flash('error', 'Permintaan otorisasi resmi ditolak oleh Owner.');
    }

    public function render()
    {
        return view('livewire.owner.stock-adjustment-index', [
            'adjustments' => StockAdjustments::with(['branch', 'product', 'user'])
                ->where('status', 'escalated_to_owner')
                ->latest()
                ->paginate(11)
        ])->layout('layouts.app');
    }
}