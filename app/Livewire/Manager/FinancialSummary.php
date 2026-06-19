<?php

namespace App\Livewire\Manager;

use App\Models\Transactions;
use App\Models\AuditLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FinancialSummary extends Component
{
    public $filterDate;

    // State untuk modal verifikasi kasir
    public $showVerifyModal = false;
    public $selectedCashierId;
    public $selectedCashierName;
    public $systemAmount = 0;
    public $physicalAmount = 0;
    public $notes = '';

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->filterDate = Carbon::today()->format('Y-m-d');
    }

    /**
     * Membuka modal verifikasi untuk kasir tertentu
     */
    public function openVerification($cashierId, $cashierName, $systemAmount)
    {
        $this->selectedCashierId = $cashierId;
        $this->selectedCashierName = $cashierName;
        $this->systemAmount = $systemAmount;

        // Cari tahu apakah sudah pernah diinput sebelumnya pada tanggal ini
        $existingRecon = Transactions::where('branch_id', auth()->user()->branch_id)
            ->where('user_id', $cashierId)
            ->whereDate('created_at', $this->filterDate)
            ->first();

        // Jika sudah pernah diverifikasi, tampilkan data yang tersimpan di database. 
        // Jika belum, samakan dengan systemAmount sebagai nilai awal (default)
        $this->physicalAmount = $existingRecon && $existingRecon->status_verifikasi === 'verified'
            ? $existingRecon->uang_fisik
            : $systemAmount;

        $this->notes = $existingRecon ? $existingRecon->catatan_manajer : '';
        $this->showVerifyModal = true;
    }

    /**
     * Menyimpan hasil rekonsiliasi fisik & mencatatnya ke database
     */
    public function saveVerification()
    {
        $this->validate([
            'physicalAmount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:255',
        ]);

        $managerBranchId = auth()->user()->branch_id;
        $difference = $this->physicalAmount - $this->systemAmount;

        // Menentukan status/label selisih
        if ($difference === 0) {
            $statusLabel = "SESUAI / BALANCE";
        } elseif ($difference < 0) {
            $statusLabel = "KURANG (Shortage) sebesar Rp " . number_format(abs($difference), 0, ',', '.');
        } else {
            $statusLabel = "LEBIH (Overage) sebesar Rp " . number_format($difference, 0, ',', '.');
        }

        // 1. Update status transaksi kasir bersangkutan pada tanggal tersebut ke database
        Transactions::where('branch_id', $managerBranchId)
            ->where('user_id', $this->selectedCashierId)
            ->whereDate('created_at', $this->filterDate)
            ->update([
                'status_verifikasi' => 'verified',
                'uang_fisik' => $this->physicalAmount,
                'catatan_manajer' => $this->notes ?: null
            ]);

        // 2. Catat rekonsiliasi ke dalam AuditLog pusat
        AuditLog::create([
            'branch_id' => $managerBranchId,
            'user_id' => auth()->id(),
            'action' => 'FINANCIAL_RECONCILIATION',
            'description' => "Manager memverifikasi keuangan Kasir {$this->selectedCashierName} pada tanggal {$this->filterDate}. Nilai Sistem: Rp " . number_format($this->systemAmount, 0, ',', '.') . " | Uang Fisik: Rp " . number_format($this->physicalAmount, 0, ',', '.') . " | Status: {$statusLabel}. Catatan: " . ($this->notes ?: '-')
        ]);

        $this->showVerifyModal = false;
        session()->flash('success', "Berhasil melakukan rekonsiliasi kas untuk {$this->selectedCashierName}. Status: {$statusLabel}");
    }

    public function render()
    {
        $managerBranchId = auth()->user()->branch_id;

        // Ambil summary setoran kasir berdasarkan transaksi riil di cabang manager aktif
        // Menggunakan MAX() untuk kolom rekonsiliasi agar nilainya tidak terakumulasi ganda saat group by
        $cashierSummaries = Transactions::select(
            'user_id',
            DB::raw('SUM(total_price) as total_deposit'),
            DB::raw('COUNT(id) as transaction_count'),
            DB::raw('MAX(status_verifikasi) as status_verifikasi'),
            DB::raw('MAX(uang_fisik) as nominal_uang_fisik'),
            DB::raw('MAX(catatan_manajer) as catatan_manajer')
        )
            ->where('branch_id', $managerBranchId)
            ->whereDate('created_at', $this->filterDate)
            ->groupBy('user_id')
            ->with('user')
            ->get();

        // Hitung agregat total untuk kartu informasi (Stats Card)
        $grandTotalDeposit = $cashierSummaries->sum('total_deposit');
        $grandTotalTransactions = $cashierSummaries->sum('transaction_count');

        return view('livewire.manager.financial-summary', compact(
            'cashierSummaries',
            'grandTotalDeposit',
            'grandTotalTransactions'
        ))->layout('layouts.app');
    }
}