<?php

namespace App\Livewire\Manager;

use App\Models\CashierCorrections;
use App\Models\TransactionsDetail;
use App\Models\Transactions;
use App\Models\StockLogs;
use App\Models\Stocks;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class VerifyEscalatedCorrection extends Component
{
    use WithPagination;

    public function approveByManager($id)
    {
        DB::transaction(function () use ($id) {
            $correction = CashierCorrections::lockForUpdate()->findOrFail($id);

            // Manager hanya berhak memproses berkas yang dilempar dari supervisor (escalated_to_manager)
            if ($correction->status !== 'escalated_to_manager')
                return;

            // 1. Kembalikan produk void ke stok inventori
            $stock = Stocks::where('product_id', $correction->product_id)->first();
            if ($stock) {
                $stock->increment('quantity', $correction->quantity_difference);
            }

            // 2. Catat riwayat log penyesuaian inventori
            StockLogs::create([
                'branch_id' => $correction->branch_id,
                'product_id' => $correction->product_id,
                'user_id' => $correction->user_id,
                'type' => 'adjustment',
                'amount' => $correction->quantity_difference,
                'reason' => "Stok kembali otomatis dari pembatalan POS Kasir (Otorisasi Manager Cabang)",
            ]);

            // 3. Sinkronisasi kuantitas baru pada model TransactionsDetail
            $detail = TransactionsDetail::where('transaction_id', $correction->transaction_id)
                ->where('product_id', $correction->product_id)
                ->first();

            if ($detail) {
                $detail->update(['qty' => $correction->corrected_quantity]);
            }

            // 4. Hitung ulang nominal transaksi utama nota belanja
            $newTotal = TransactionsDetail::where('transaction_id', $correction->transaction_id)
                ->selectRaw('SUM(qty * price_at_transaction) as total')
                ->value('total') ?? 0;

            Transactions::where('id', $correction->transaction_id)->update(['total_price' => $newTotal]);

            // 5. Perbarui status ajuan menjadi disetujui (approved) oleh Manajer
            $correction->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'reason' => $correction->reason . " [DISETUJUI OLEH MANAGER]"
            ]);

            session()->flash('message', 'Otorisasi koreksi bernilai besar sukses diverifikasi dan disetujui oleh Manager.');
        });
    }

    public function rejectByManager($id)
    {
        $correction = CashierCorrections::findOrFail($id);
        if ($correction->status === 'escalated_to_manager') {
            $correction->update([
                'status' => 'rejected',
                'approved_by' => auth()->id(),
                'reason' => $correction->reason . " [DITOLAK OLEH MANAGER]"
            ]);
            session()->flash('error', 'Berkas klaim koreksi nota resmi ditolak oleh Manager Cabang.');
        }
    }

    public function render()
    {
        $escalatedCorrections = CashierCorrections::with(['transaction', 'product', 'user'])
            ->where('branch_id', auth()->user()->branch_id ?? 1)
            ->where('status', 'escalated_to_manager')
            ->latest()
            ->paginate(10);

        return view('livewire.manager.verify-escalated-correction', [
            'corrections' => $escalatedCorrections
        ])->layout('layouts.app');
    }
}