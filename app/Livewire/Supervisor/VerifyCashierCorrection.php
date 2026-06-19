<?php

namespace App\Livewire\Supervisor;

use App\Models\CashierCorrections;
use App\Models\TransactionsDetail;
use App\Models\Transactions;
use App\Models\StockLogs;
use App\Models\Stocks;
use App\Models\AuditLog; // <--- PASTIKAN IMPORT MODEL INI
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class VerifyCashierCorrection extends Component
{
    use WithPagination;

    const WAWENANG_SUPERVISOR_LIMIT = 200000;

    public function approve($id)
    {
        DB::transaction(function () use ($id) {
            $correction = CashierCorrections::lockForUpdate()->findOrFail($id);
            if ($correction->status !== 'pending')
                return;

            if ($correction->financial_impact >= self::WAWENANG_SUPERVISOR_LIMIT) {
                $correction->update([
                    'status' => 'escalated_to_manager',
                    'reason' => $correction->reason . " [DILANJUTKAN OLEH SUPERVISOR: Nominal " . number_format($correction->financial_impact) . " melampaui batas Rp200.000, butuh otorisasi Manajer]"
                ]);

                // 📝 REKAM AUDIT LOG: ESKALASI KE MANAGER
                AuditLog::create([
                    'branch_id' => $correction->branch_id,
                    'user_id' => auth()->id(),
                    'action' => 'ESCALATE',
                    'description' => "Meneruskan koreksi kasir nota #{$correction->transaction_id} ke Manajer karena nilai kerugian (Rp " . number_format($correction->financial_impact, 0, ',', '.') . ") di atas batas wewenang."
                ]);

                session()->flash('message', 'Nilai perubahan besar. Berkas koreksi otomatis dialihkan ke dashboard Manajer Cabang.');
            } else {
                $this->executeSystemAdjustment($correction);
                $correction->update([
                    'status' => 'approved',
                    'approved_by' => auth()->id()
                ]);

                // 📝 REKAM AUDIT LOG: APPROVE INSTAN
                AuditLog::create([
                    'branch_id' => $correction->branch_id,
                    'user_id' => auth()->id(),
                    'action' => 'APPROVE',
                    'description' => "Menyetujui koreksi kasir nota #{$correction->transaction_id} untuk produk {$correction->product->name} (Selisih: -{$correction->quantity_difference} pcs)."
                ]);

                session()->flash('message', 'Koreksi transaksi bernilai minor berhasil disetujui langsung oleh Supervisor.');
            }
        });
    }

    public function reject($id)
    {
        $correction = CashierCorrections::findOrFail($id);
        if ($correction->status === 'pending') {
            $correction->update([
                'status' => 'rejected',
                'approved_by' => auth()->id()
            ]);

            // 📝 REKAM AUDIT LOG: REJECT KOREKSI
            AuditLog::create([
                'branch_id' => $correction->branch_id,
                'user_id' => auth()->id(),
                'action' => 'REJECT',
                'description' => "Menolak permintaan koreksi transaksi kasir pada nota #{$correction->transaction_id}."
            ]);

            session()->flash('error', 'Permintaan koreksi kasir resmi ditolak.');
        }
    }

    protected function executeSystemAdjustment($correction)
    {
        $stock = Stocks::where('product_id', $correction->product_id)->first();
        if ($stock) {
            $stock->increment('quantity', $correction->quantity_difference);
        }

        StockLogs::create([
            'branch_id' => $correction->branch_id,
            'product_id' => $correction->product_id,
            'user_id' => $correction->user_id,
            'type' => 'adjustment',
            'amount' => $correction->quantity_difference,
            'reason' => "Pengembalian stok dari pembatalan item POS Kasir (Disetujui SPV)",
        ]);

        $detail = TransactionsDetail::where('transaction_id', $correction->transaction_id)
            ->where('product_id', $correction->product_id)
            ->first();

        if ($detail) {
            $detail->update(['qty' => $correction->corrected_quantity]);
        }

        $newTotal = TransactionsDetail::where('transaction_id', $correction->transaction_id)
            ->selectRaw('SUM(qty * price_at_transaction) as total')
            ->value('total') ?? 0;

        Transactions::where('id', $correction->transaction_id)->update(['total_price' => $newTotal]);
    }

    public function render()
    {
        $corrections = CashierCorrections::with(['transaction', 'product', 'user'])
            ->where('branch_id', auth()->user()->branch_id ?? 1)
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('livewire.supervisor.verify-cashier-correction', [
            'corrections' => $corrections
        ])->layout('layouts.app');
    }
}