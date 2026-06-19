<?php

namespace App\Livewire\Manager;

use App\Models\Stocks;
use App\Models\Transactions;
use App\Models\TransactionsDetail;
use App\Models\CashierCorrections;
use App\Models\AuditLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    // Fungsi Otorisasi Langsung dari Dashboard Manager untuk Berkas Besar (>= 200rb)
    public function approveEscalated($id)
    {
        DB::transaction(function () use ($id) {
            $correction = CashierCorrections::lockForUpdate()->findOrFail($id);

            if ($correction->status !== 'escalated_to_manager')
                return;

            // 1. Kembalikan produk ke stok cabang terkait
            $stock = Stocks::where('product_id', $correction->product_id)
                ->where('branch_id', $correction->branch_id)
                ->first();

            if ($stock) {
                $stock->increment('quantity', $correction->quantity_difference);
            }

            // 2. Sinkronisasi kuantitas baru pada detail transaksi
            TransactionsDetail::where('transaction_id', $correction->transaction_id)
                ->where('product_id', $correction->product_id)
                ->update(['qty' => $correction->corrected_quantity]);

            // 3. Hitung Ulang Omzet Nota Terkait
            $newTotal = TransactionsDetail::where('transaction_id', $correction->transaction_id)
                ->sum(DB::raw('qty * price_at_transaction'));

            Transactions::where('id', $correction->transaction_id)->update(['total_price' => $newTotal]);

            // 4. Update status berkas koreksi
            $correction->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'reason' => $correction->reason . " [OTORISASI MANAGER DISETUJUI]"
            ]);

            // 5. Rekam Audit Log
            AuditLog::create([
                'branch_id' => $correction->branch_id,
                'user_id' => auth()->id(),
                'action' => 'APPROVE_MANAGER',
                'description' => "Manager menyetujui otorisasi koreksi bernilai besar untuk Nota ID #{$correction->transaction_id}."
            ]);

            session()->flash('success', 'Otorisasi transaksi besar berhasil disetujui, omzet cabang telah disesuaikan.');
        });
    }

    public function rejectEscalated($id)
    {
        $correction = CashierCorrections::findOrFail($id);
        if ($correction->status === 'escalated_to_manager') {
            $correction->update([
                'status' => 'rejected',
                'approved_by' => auth()->id(),
                'reason' => $correction->reason . " [DITOLAK OLEH MANAGER]"
            ]);

            AuditLog::create([
                'branch_id' => $correction->branch_id,
                'user_id' => auth()->id(),
                'action' => 'REJECT_MANAGER',
                'description' => "Manager menolak berkas koreksi besar untuk Nota ID #{$correction->transaction_id}."
            ]);

            session()->flash('error', 'Berkas otorisasi koreksi resmi ditolak.');
        }
    }

    public function render()
    {
        $today = Carbon::today();
        $managerBranchId = auth()->user()->branch_id;

        // 📊 1. Finansial Ringkasan
        $totalOmzet = Transactions::where('branch_id', $managerBranchId)
            ->whereDate('created_at', $today)
            ->sum('total_price');

        $totalTransactions = Transactions::where('branch_id', $managerBranchId)
            ->whereDate('created_at', $today)
            ->count();

        // 📉 2. Analisis Kebocoran Omzet (Nilai Koreksi yang disetujui hari ini)
        $totalLeakedCorrection = CashierCorrections::where('branch_id', $managerBranchId)
            ->where('status', 'approved')
            ->whereDate('updated_at', $today)
            ->sum('financial_impact');

        // ⚠️ 3. Kontrol Stok Kritis (Mendekati limit minimum)
        $lowStocks = Stocks::with('product')
            ->where('branch_id', $managerBranchId)
            ->whereColumn('quantity', '<=', 'low_stock_threshold')
            ->get();

        // 🔥 4. Ranah Keputusan: Berkas yang Butuh Otorisasi Manager Sengit (>= 200.000)
        $escalatedCorrections = CashierCorrections::with(['transaction', 'product', 'user'])
            ->where('branch_id', $managerBranchId)
            ->where('status', 'escalated_to_manager')
            ->latest()
            ->get();

        // 🏆 5. Produk Terlaris (Analisis Pareto / Product Performance)
        $bestSellers = TransactionsDetail::select('product_id', DB::raw('SUM(qty) as total_sold'))
            ->whereHas('transaction', function ($q) use ($today, $managerBranchId) {
                $q->where('branch_id', $managerBranchId)
                    ->whereDate('created_at', $today);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->with('product')
            ->get();

        return view('livewire.manager.dashboard', compact(
            'totalOmzet',
            'totalTransactions',
            'totalLeakedCorrection',
            'lowStocks',
            'escalatedCorrections',
            'bestSellers'
        ));
    }
}