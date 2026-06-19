<?php

namespace App\Livewire\Manager;

use App\Models\Products;
use App\Models\StockAdjustments;
use App\Models\StockLogs;
use App\Models\Stocks;
use App\Models\AuditLog; // <--- PASTIKAN MODEL INI DIIMPORT
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StockAdjustmentCreate extends Component
{
    public $product_id;
    public $branch_id;
    public $adjustment_amount;
    public $reason;
    public $current_stock = 0;

    const LIMIT_MANAGER = 1000000;

    protected function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'adjustment_amount' => 'required|integer|not_in:0',
            'reason' => 'required|string|min:5',
        ];
    }

    public function mount()
    {
        $this->branch_id = Auth::user()->branch_id;
    }

    public function updatedProductId($value)
    {
        $stock = Stocks::where('branch_id', $this->branch_id)->where('product_id', $value)->first();
        $this->current_stock = $stock ? $stock->quantity : 0;
    }

    public function submitAdjustment()
    {
        $this->validate();
        $user = Auth::user();
        $product = Products::find($this->product_id);
        $totalImpact = abs($this->adjustment_amount) * ($product->sell_price ?? 0);
        $newQuantity = $this->current_stock + $this->adjustment_amount;

        if ($newQuantity < 0) {
            session()->flash('error', 'Koreksi gagal. Hasil perhitungan akhir kuantitas stok tidak boleh minus.');
            return;
        }

        if ($totalImpact >= self::LIMIT_MANAGER) {
            $status = 'escalated_to_owner';
            $approvedBy = null;
        } else {
            $status = 'approved';
            $approvedBy = $user->id;
        }

        DB::transaction(function () use ($user, $product, $newQuantity, $status, $approvedBy, $totalImpact) {
            StockAdjustments::create([
                'branch_id' => $this->branch_id,
                'product_id' => $this->product_id,
                'user_id' => $user->id,
                'old_quantity' => $this->current_stock,
                'new_quantity' => $newQuantity,
                'adjustment_amount' => $this->adjustment_amount,
                'reason' => "Koreksi Insidental Manager: " . $this->reason,
                'status' => $status,
                'approved_by' => $approvedBy
            ]);

            if ($status === 'approved') {
                // 🔒 AMAN: Mengunci branch_id agar perubahan stok tidak berdampak global
                Stocks::where('branch_id', $this->branch_id)
                    ->where('product_id', $this->product_id)
                    ->update(['quantity' => $newQuantity]);

                StockLogs::create([
                    'branch_id' => $this->branch_id,
                    'product_id' => $this->product_id,
                    'user_id' => $user->id,
                    'type' => 'adjustment',
                    'amount' => $this->adjustment_amount,
                    'reason' => "Manual Adjustment Disetujui Manager. Alasan: " . $this->reason,
                ]);

                // 📝 REKAM AUDIT LOG: PENYESUAIAN STOK INSIDENTAL LANGSUNG
                AuditLog::create([
                    'branch_id' => $this->branch_id,
                    'user_id' => $user->id,
                    'action' => 'CREATE',
                    'description' => "Manager membuat adjustment insidental langsung untuk produk {$product->name} (Kuantitas: {$this->adjustment_amount} pcs)."
                ]);
            } else {
                // 📝 REKAM AUDIT LOG: ESKALASI KOREKSI KE OWNER
                AuditLog::create([
                    'branch_id' => $this->branch_id,
                    'user_id' => $user->id,
                    'action' => 'ESCALATE',
                    'description' => "Pengajuan adjustment insidental {$product->name} oleh Manager dialihkan otomatis ke Owner karena nilai taksiran mencapai Rp " . number_format($totalImpact, 0, ',', '.') . "."
                ]);
            }
        });

        session()->flash('message', $status === 'escalated_to_owner' ? 'Dampak nominal ≥ Rp1.000.000, pengajuan diteruskan ke Owner.' : 'Penyesuaian stok berhasil diterapkan.');
        return redirect()->route('manager.stockadjustmentcreate');
    }

    public function render()
    {
        return view('livewire.manager.stock-adjustment-create', [
            'products' => Products::whereHas('stocks', function ($q) {
                $q->where('branch_id', $this->branch_id);
            })->get()
        ])->layout('layouts.app');
    }
}