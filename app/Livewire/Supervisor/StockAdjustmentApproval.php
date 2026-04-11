<?php

namespace App\Livewire\Supervisor;

use Livewire\Component;
use App\Models\StockAdjustments;
use Illuminate\Support\Facades\DB;

class StockAdjustmentApproval extends Component
{

    public function approve($id)
    {
        $adjustment = \App\Models\StockAdjustments::with('product')->findOrFail($id);

        // ❗ Cegah double approve
        if ($adjustment->status !== 'pending') {
            return;
        }

        try {
            DB::transaction(function () use ($adjustment) {

                $product = $adjustment->product;

                // 🔥 VALIDASI (kalau pengurangan stok)
                if ($adjustment->adjustment_amount < 0) {
                    if ($product->stock < abs($adjustment->adjustment_amount)) {
                        throw new \Exception('Stok tidak cukup untuk dikurangi');
                    }
                }

                // ✅ UPDATE STOCK
                $product->stock = $adjustment->new_quantity;
                $product->save();

                // ✅ UPDATE STATUS
                $adjustment->update([
                    'status' => 'approved',
                    'approved_by' => auth()->id(),
                ]);
            });

            session()->flash('message', 'Adjustment berhasil di-approve');

        } catch (\Exception $e) {
            session()->flash('message', $e->getMessage());
        }
    }

    public function reject($id)
    {
        $adjustment = \App\Models\StockAdjustments::findOrFail($id);

        if ($adjustment->status !== 'pending') {
            return;
        }

        $adjustment->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
        ]);

        session()->flash('message', 'Adjustment ditolak');
    }

    public function render()
    {
        $requests = StockAdjustments::with(['product','user','branch'])
            ->where('status','pending')
            ->latest()
            ->get();

        return view('livewire.supervisor.stock-adjustment-approval', [
            'requests' => $requests
        ]);
    }
}