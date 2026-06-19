<?php

namespace App\Livewire\Supervisor;

use App\Models\StockAdjustments;
use App\Models\StockLogs;
use App\Models\Stocks;
use App\Models\AuditLog; // <--- PASTIKAN IMPORT MODEL INI
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class VerifyOpname extends Component
{
    use WithPagination;

    const LIMIT_SUPERVISOR = 200000;
    public $re_audit_reason = [];

    public function verify($id)
    {
        DB::transaction(function () use ($id) {
            $adjustment = StockAdjustments::lockForUpdate()->findOrFail($id);

            if ($adjustment->status !== 'pending') {
                session()->flash('error', 'Laporan opname ini sudah diproses.');
                return;
            }

            $productPrice = $adjustment->product->sell_price ?? 0;
            $totalImpact = abs($adjustment->adjustment_amount) * $productPrice;

            if ($totalImpact >= self::LIMIT_SUPERVISOR) {
                $adjustment->update([
                    'status' => 'escalated_to_manager',
                    'reason' => $adjustment->reason . " (Diverifikasi SPV, naik ke Manager akibat nilai >= Rp200.000)"
                ]);

                // 📝 REKAM AUDIT LOG: ESKALASI OPNAME BESAR
                AuditLog::create([
                    'branch_id' => $adjustment->branch_id,
                    'user_id' => auth()->id(),
                    'action' => 'ESCALATE',
                    'description' => "Meneruskan draf opname barang {$adjustment->product->name} ke Manajer akibat total dampak finansial (Rp " . number_format($totalImpact, 0, ',', '.') . ") melampaui limit wewenang."
                ]);

                session()->flash('message', 'Nilai menengah. Berkas diteruskan ke Manager.');
            } else {
                $stock = Stocks::where('branch_id', $adjustment->branch_id)
                    ->where('product_id', $adjustment->product_id)
                    ->first();

                if ($stock) {
                    $stock->update(['quantity' => $adjustment->new_quantity]);
                }

                StockLogs::create([
                    'branch_id' => $adjustment->branch_id,
                    'product_id' => $adjustment->product_id,
                    'user_id' => $adjustment->user_id,
                    'type' => 'adjustment',
                    'amount' => $adjustment->adjustment_amount,
                    'reason' => "Opname Disetujui Supervisor (< Rp200.000)",
                ]);

                $adjustment->update([
                    'status' => 'approved',
                    'approved_by' => auth()->id()
                ]);

                // 📝 REKAM AUDIT LOG: APPROVE OPNAME RETAIL/KERUSAKAN
                AuditLog::create([
                    'branch_id' => $adjustment->branch_id,
                    'user_id' => auth()->id(),
                    'action' => 'APPROVE',
                    'description' => "Menyetujui penyesuaian/pemutihan stok {$adjustment->product->name} (Kuantitas awal: {$adjustment->old_quantity} -> Kuantitas baru: {$adjustment->new_quantity}). Keterangan: {$adjustment->reason}"
                ]);

                session()->flash('message', 'Berkas skala minor berhasil disetujui langsung.');
            }
        });
    }

    public function requestReAudit($id)
    {
        $reasonNotes = $this->re_audit_reason[$id] ?? 'Kuantitas meragukan, tolong hitung ulang.';

        DB::transaction(function () use ($id, $reasonNotes) {
            $adjustment = StockAdjustments::lockForUpdate()->findOrFail($id);

            if ($adjustment->status !== 'pending')
                return;

            $adjustment->update([
                'status' => 're_audit',
                'reason' => "RE-AUDIT: " . $reasonNotes
            ]);

            // 📝 REKAM AUDIT LOG: PERINTAH HITUNG ULANG
            AuditLog::create([
                'branch_id' => $adjustment->branch_id,
                'user_id' => auth()->id(),
                'action' => 'UPDATE',
                'description' => "Mengirim perintah hitung ulang (Re-Audit) kepada staf untuk produk {$adjustment->product->name}. Alasan: {$reasonNotes}"
            ]);

            session()->flash('message', 'Perintah hitung ulang dikirim ke Staff.');
        });

        unset($this->re_audit_reason[$id]);
    }

    public function render()
    {
        $user = auth()->user();
        return view('livewire.supervisor.verify-opname', [
            'adjustments' => StockAdjustments::with(['product', 'user'])
                ->where('branch_id', $user->branch_id)
                ->where('status', 'pending')
                ->latest()
                ->paginate(10)
        ])->layout('layouts.app');
    }
}