<?php

namespace App\Livewire\Warehouse;

use App\Models\Products;
use App\Models\StockAdjustments;
use App\Models\Stocks;
use App\Models\AuditLog; // <--- TAMBAHKAN IMPORT
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BlindOpname extends Component
{
    public $counts = [];

    protected $rules = [
        'counts' => 'required|array',
        'counts.*' => 'nullable|integer|min:0',
    ];

    protected $validationAttributes = [
        'counts.*' => 'Jumlah hitungan fisik',
    ];

    public function submit()
    {
        $this->validate();
        $user = auth()->user();

        if (!$user || !$user->branch_id) {
            session()->flash('error', 'Akun Anda tidak terikat dengan data cabang manapun.');
            return;
        }

        DB::transaction(function () use ($user) {
            $stocks = Stocks::with('product')->where('branch_id', $user->branch_id)->get()->keyBy('id');

            foreach ($this->counts as $stockId => $countedQty) {
                if ($countedQty === '' || $countedQty === null) {
                    continue;
                }

                $stock = $stocks->get($stockId);
                if (!$stock) {
                    continue;
                }

                // Cek apakah ada instruksi Re-Audit aktif dari Supervisor
                $existingReAudit = StockAdjustments::where('branch_id', $user->branch_id)
                    ->where('product_id', $stock->product_id)
                    ->where('status', 're_audit')
                    ->first();

                if ($existingReAudit) {
                    $oldQuantity = $stock->quantity;
                    $adjustmentAmount = $countedQty - $oldQuantity;

                    $existingReAudit->update([
                        'old_quantity' => $oldQuantity,
                        'new_quantity' => $countedQty,
                        'adjustment_amount' => $adjustmentAmount,
                        'status' => 'pending' // Masuk kembali ke antrean Supervisor
                    ]);

                    // 📝 TAMBAHKAN AUDIT LOG UNTUK RE-AUDIT
                    AuditLog::create([
                        'branch_id' => $user->branch_id,
                        'user_id' => $user->id,
                        'action' => 'SUBMIT_RE_AUDIT',
                        'description' => "Staf Gudang mengirimkan hitung ulang (Re-Audit) untuk {$stock->product->name} dengan fisik: {$countedQty} pcs."
                    ]);
                } else {
                    $oldQuantity = $stock->quantity;
                    $adjustmentAmount = $countedQty - $oldQuantity;

                    if ($adjustmentAmount != 0) {
                        StockAdjustments::create([
                            'branch_id' => $user->branch_id,
                            'product_id' => $stock->product_id,
                            'user_id' => $user->id,
                            'old_quantity' => $oldQuantity,
                            'new_quantity' => $countedQty,
                            'adjustment_amount' => $adjustmentAmount,
                            'reason' => 'Blind Stock Opname harian oleh Staff Gudang.',
                            'status' => 'pending'
                        ]);

                        // 📝 TAMBAHKAN AUDIT LOG UNTUK OPNAME BARU
                        AuditLog::create([
                            'branch_id' => $user->branch_id,
                            'user_id' => $user->id,
                            'action' => 'SUBMIT_OPNAME',
                            'description' => "Staf Gudang memasukkan draf opname baru untuk {$stock->product->name} dengan fisik: {$countedQty} pcs."
                        ]);
                    }
                }
            }
        });

        $this->counts = [];
        session()->flash('message', 'Hasil pemeriksaan opname berhasil dikirim ke Supervisor.');
    }

    public function render()
    {
        $user = auth()->user();
        $branchStocks = collect();

        if ($user && $user->branch_id) {
            $branchStocks = Stocks::with('product')
                ->where('branch_id', $user->branch_id)
                ->get();
        }

        return view('livewire.warehouse.blind-opname', [
            'stocks' => $branchStocks
        ])->layout('layouts.app');
    }
}