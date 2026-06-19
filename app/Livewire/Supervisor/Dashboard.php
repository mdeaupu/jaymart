<?php

namespace App\Livewire\Supervisor;

use Livewire\Component;
use App\Models\Transactions;
use App\Models\CashierCorrections;
use App\Models\Stocks;
use App\Models\AuditLog; // <--- TAMBAHKAN IMPORT MODEL
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    // Fungsi Approval Void Langsung dari Dashboard
    public function approveVoid($correctionId)
    {
        DB::transaction(function () use ($correctionId) {
            $correction = CashierCorrections::lockForUpdate()->findOrFail($correctionId);

            if ($correction->status !== 'pending')
                return;

            // Batas wewenang finansial Supervisor (Rp 200.000)
            if ($correction->financial_impact >= 200000) {
                $correction->update([
                    'status' => 'escalated_to_manager',
                    'reason' => $correction->reason . " [DILANJUTKAN SPV: Nominal besar, butuh otorisasi Manajer]"
                ]);

                // Rekam Audit Log untuk Eskalasi
                AuditLog::create([
                    'branch_id' => $correction->branch_id,
                    'user_id' => auth()->id(),
                    'action' => 'ESCALATE',
                    'description' => "Meneruskan koreksi nota #{$correction->transaction_id} ke Manajer Cabang (Dampak: Rp " . number_format($correction->financial_impact) . ")."
                ]);

                session()->flash('message', 'Nilai perubahan besar. Berkas koreksi otomatis dialihkan ke dashboard Manajer Cabang.');
            } else {
                // Jalankan update stok, detail item, dan HITUNG ULANG OMZET
                $this->executeSystemAdjustment($correction);

                // Update status pengajuan koreksi
                $correction->update([
                    'status' => 'approved',
                    'approved_by' => auth()->id()
                ]);

                // Rekam Audit Log untuk Persetujuan
                AuditLog::create([
                    'branch_id' => $correction->branch_id,
                    'user_id' => auth()->id(),
                    'action' => 'APPROVE',
                    'description' => "Supervisor menyetujui koreksi transaksi kasir untuk Nota ID #{$correction->transaction_id}."
                ]);

                session()->flash('success', 'Koreksi transaksi bernilai minor berhasil disetujui langsung oleh Supervisor.');
            }
        });
    }

    // 🔄 TAMBAHKAN method baru ini di bawah approveVoid() untuk memproses perhitungan database
    protected function executeSystemAdjustment($correction)
    {
        // 1. Kembalikan selisih barang fisik ke stok gudang cabang harian
        $stock = Stocks::where('product_id', $correction->product_id)
            ->where('branch_id', $correction->branch_id)
            ->first();

        if ($stock) {
            $stock->increment('quantity', $correction->quantity_difference);
        }

        // 2. Catat riwayat log penyesuaian inventori
        \App\Models\StockLogs::create([
            'branch_id' => $correction->branch_id,
            'product_id' => $correction->product_id,
            'user_id' => $correction->user_id,
            'type' => 'adjustment',
            'amount' => $correction->quantity_difference,
            'reason' => "Stok kembali otomatis dari pembatalan POS Kasir (Disetujui SPV)",
        ]);

        // 3. Paksa sinkronisasi kuantitas baru pada detail transaksi menggunakan Model Eloquent
        \App\Models\TransactionsDetail::where('transaction_id', $correction->transaction_id)
            ->where('product_id', $correction->product_id)
            ->update(['qty' => $correction->corrected_quantity]);

        // 4. 🔄 HITUNG ULANG OMZET: Hitung matematika total belanja pasca-void secara presisi
        $newTotal = \App\Models\TransactionsDetail::where('transaction_id', $correction->transaction_id)
            ->sum(DB::raw('qty * price_at_transaction'));

        // 5. Update tabel Transactions utama agar nominal nota belanja menyusut berkurang
        Transactions::where('id', $correction->transaction_id)->update(['total_price' => $newTotal]);
    }

    public function render()
    {
        $branchId = auth()->user()->branch_id;

        // 1. Hitung ringkasan penjualan & transaksi khusus cabang ini saja
        $totalSalesToday = Transactions::where('branch_id', $branchId)
            ->whereDate('created_at', Carbon::today())
            ->sum('total_price');

        $transactionCountToday = Transactions::where('branch_id', $branchId)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $pendingVoidCount = CashierCorrections::where('branch_id', $branchId)
            ->where('status', 'pending')
            ->count();

        // 2. Batas Stok Menipis (Contoh di bawah 15 pcs)
        $lowStockProducts = Stocks::with('product')
            ->where('branch_id', $branchId)
            ->where('quantity', '<=', 15)
            ->take(5)
            ->get();

        // 3. Antrean Request Void Aktif
        $pendingCorrections = CashierCorrections::with(['transaction', 'product', 'user'])
            ->where('branch_id', $branchId)
            ->where('status', 'pending')
            ->latest()
            ->get();

        // 4. Feed Transaksi Kasir Terbaru (Realtime Tracker)
        $recentTransactions = Transactions::with('user')
            ->where('branch_id', $branchId)
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.supervisor.dashboard', [
            'totalSalesToday' => $totalSalesToday,
            'transactionCountToday' => $transactionCountToday,
            'pendingVoidCount' => $pendingVoidCount,
            'lowStockProducts' => $lowStockProducts,
            'pendingCorrections' => $pendingCorrections,
            'recentTransactions' => $recentTransactions,
        ])->layout('layouts.app');
    }
}