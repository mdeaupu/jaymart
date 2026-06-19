<?php

namespace App\Livewire\Manager;

use App\Models\StockAdjustments;
use App\Models\StockLogs;
use App\Models\Stocks;
use App\Models\AuditLog; // <--- SEGERA IMPORT MODEL INI
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class StockAdjustmentReview extends Component
{
    use WithPagination;

    const LIMIT_MANAGER = 1000000;

    public function approve($id)
    {
        DB::transaction(function () use ($id) {
            $adj = StockAdjustments::lockForUpdate()->with('product')->findOrFail($id);

            if ($adj->status !== 'escalated_to_manager')
                return;

            $productPrice = $adj->product->sell_price ?? 0;
            $totalImpact = abs($adj->adjustment_amount) * $productPrice;

            if ($totalImpact >= self::LIMIT_MANAGER) {
                $adj->update([
                    'status' => 'escalated_to_owner',
                    'reason' => $adj->reason . " (Direview Manager, naik ke Owner karena nilai >= Rp1.000.000)"
                ]);

                // 📝 REKAM AUDIT LOG: ESKALASI TINGKAT LANJUT OLEH MANAJER KE OWNER
                AuditLog::create([
                    'branch_id' => $adj->branch_id,
                    'user_id' => auth()->id(),
                    'action' => 'ESCALATE',
                    'description' => "Manajer meneruskan berkas penyesuaian stok {$adj->product->name} ke Owner akibat dampak finansial besar (Rp " . number_format($totalImpact, 0, ',', '.') . ") di luar batas wewenang Manajer."
                ]);

                session()->flash('message', 'Nilai melampaui Rp1.000.000, dialihkan ke Owner.');
            } else {
                Stocks::where('branch_id', $adj->branch_id)
                    ->where('product_id', $adj->product_id)
                    ->update(['quantity' => $adj->new_quantity]);

                StockLogs::create([
                    'branch_id' => $adj->branch_id,
                    'product_id' => $adj->product_id,
                    'user_id' => $adj->user_id,
                    'type' => 'adjustment',
                    'amount' => $adj->adjustment_amount,
                    'reason' => "Disetujui oleh Manager Cabang",
                ]);

                $adj->update([
                    'status' => 'approved',
                    'approved_by' => auth()->id()
                ]);

                // 📝 REKAM AUDIT LOG: PERSETUJUAN BERKAS OLEH MANAJER
                AuditLog::create([
                    'branch_id' => $adj->branch_id,
                    'user_id' => auth()->id(),
                    'action' => 'APPROVE',
                    'description' => "Manajer menyetujui penyesuaian opname untuk produk {$adj->product->name} (Selisih: {$adj->adjustment_amount} pcs) dengan taksiran kerugian/keuntungan senilai Rp " . number_format($totalImpact, 0, ',', '.') . "."
                ]);

                session()->flash('message', 'Berkas penyesuaian berhasil disetujui.');
            }
        });
    }

    public function reject($id)
    {
        $adj = StockAdjustments::with('product')->findOrFail($id);
        if ($adj->status === 'escalated_to_manager') {
            $adj->update([
                'status' => 'rejected',
                'approved_by' => auth()->id()
            ]);

            // 📝 REKAM AUDIT LOG: PENOLAKAN BERKAS OLEH MANAJER
            AuditLog::create([
                'branch_id' => $adj->branch_id,
                'user_id' => auth()->id(),
                'action' => 'REJECT',
                'description' => "Manajer menolak berkas ajuan opname penyesuaian stok untuk produk {$adj->product->name}."
            ]);

            session()->flash('error', 'Berkas resmi ditolak oleh Manager.');
        }
    }

    public function render()
    {
        $user = auth()->user();
        return view('livewire.manager.stock-adjustment-review', [
            'adjustments' => StockAdjustments::with(['product', 'user'])
                ->where('branch_id', $user->branch_id)
                ->where('status', 'escalated_to_manager')
                ->latest()
                ->paginate(10)
        ])->layout('layouts.app');
    }
}