<?php

namespace App\Livewire\Owner;

use App\Models\StockPurchase;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class StockApproval extends Component
{
    use WithPagination;

    // Properti baru untuk menyimpan data nota yang sedang di-review/dilihat
    public $selectedPurchase = null;
    public $showDetailModal = false;

    public function approvePurchase($id)
    {
        DB::transaction(function () use ($id) {
            $purchase = StockPurchase::findOrFail($id);

            $purchase->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
            ]);
        });

        // Jika modal sedang terbuka untuk item ini, tutup modal
        if ($this->selectedPurchase && $this->selectedPurchase->id == $id) {
            $this->closeDetailModal();
        }

        session()->flash('message', 'Pembelian stok berhasil disetujui. Status diperbarui, menunggu verifikasi fisik oleh Warehouse.');
    }

    public function rejectPurchase($id)
    {
        $purchase = StockPurchase::findOrFail($id);
        $purchase->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
        ]);

        if ($this->selectedPurchase && $this->selectedPurchase->id == $id) {
            $this->closeDetailModal();
        }

        session()->flash('message', 'Pembelian stok telah ditolak.');
    }

    // Fungsi baru untuk memuat detail nota ke dalam modal
    public function viewDetail($id)
    {
        // Muat data beserta relasi lengkapnya
        $this->selectedPurchase = StockPurchase::with(['details.product', 'supplier', 'branch', 'user'])
            ->findOrFail($id);
        $this->showDetailModal = true;
    }

    // Fungsi untuk menutup modal
    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedPurchase = null;
    }

    public function render()
    {
        return view('livewire.owner.stock-approval', [
            'purchases' => StockPurchase::with(['details.product', 'supplier', 'branch'])
                ->where('status', 'pending')
                ->latest()
                ->paginate(10),
        ])->layout('layouts.app');
    }
}