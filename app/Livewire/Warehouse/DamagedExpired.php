<?php

namespace App\Livewire\Warehouse;

use App\Models\StockAdjustments;
use App\Models\Stocks;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DamagedExpired extends Component
{
    public $product_id, $quantity, $type = 'expired', $reason;

    public function save()
    {
        $this->validate([
            'product_id' => 'required|exists:stocks,product_id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:expired,out',
            'reason' => 'required|string|max:255',
        ]);

        $branchId = auth()->user()->branch_id;

        // Ambil data stok terkini di cabang tersebut beserta harga jual produknya
        $stock = Stocks::with('product')
            ->where('branch_id', $branchId)
            ->where('product_id', $this->product_id)
            ->first();

        if (!$stock) {
            session()->flash('error', 'Produk tidak ditemukan di cabang ini.');
            return;
        }

        if ($stock->quantity < $this->quantity) {
            session()->flash('error', 'Stok fisik komputer tidak mencukupi untuk dikurangi.');
            return;
        }

        DB::transaction(function () use ($stock, $branchId) {
            $oldQuantity = $stock->quantity;
            $newQuantity = $oldQuantity - $this->quantity;

            // Hitung taksiran kerugian finansial akibat barang rusak/expired
            $productPrice = $stock->product->sell_price ?? 0;
            $financialImpact = $this->quantity * $productPrice;

            // Format keterangan penanda kategori agar dibaca oleh Supervisor/Manager
            $tag = $this->type === 'expired' ? '[EXPIRED]' : '[OUT]';
            $formattedReason = "{$tag} " . $this->reason . " (Taksiran Kerugian: Rp " . number_format($financialImpact, 0, ',', '.') . ")";

            // ALIRKAN SEBAGAI DRAF PENDING (Tidak memotong stok secara langsung)
            StockAdjustments::create([
                'branch_id' => $branchId,
                'product_id' => $this->product_id,
                'user_id' => auth()->id(),
                'old_quantity' => $oldQuantity,
                'new_quantity' => $newQuantity,
                'adjustment_amount' => -$this->quantity, // minus karena mengurangi stok aset
                'reason' => $formattedReason,
                'status' => 'pending' // Default pending agar diverifikasi berjenjang
            ]);

            // 📝 REKAM AUDIT LOG: PENGAJUAN OLEH STAF GUDANG
            $labelAksi = $this->type === 'expired' ? 'SUBMIT_EXPIRED' : 'SUBMIT_DAMAGED';
            AuditLog::create([
                'branch_id' => $branchId,
                'user_id' => auth()->id(),
                'action' => $labelAksi,
                'description' => "Mengajukan pemutihan stok {$stock->product->name} sebanyak {$this->quantity} pcs. Menunggu verifikasi berjenjang."
            ]);
        });

        // Notifikasi sukses melayang yang informatif
        session()->flash('message', 'Draf kerusakan berhasil dikirim. Sistem akan mengarahkan dokumen ini ke Supervisor atau Manajer sesuai nilai kerugian.');

        $this->reset(['quantity', 'reason']);
    }

    public function render()
    {
        return view('livewire.warehouse.damaged-expired', [
            'stocks' => Stocks::with('product')->where('branch_id', auth()->user()->branch_id)->get()
        ])->layout('layouts.app');
    }
}