<?php

namespace App\Livewire\Manager;

use App\Models\Products;
use App\Models\StockPurchase;
use App\Models\StockPurchaseDetail;
use App\Models\Supplier;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads; // <--- 1. IMPORT TRAIT FILE UPLOADS

class StockPurchaseCreate extends Component
{
    use WithFileUploads; // <--- 2. GUNAKAN TRAIT DI SINI

    public $supplier_id;
    public $purchase_date;
    public $po_number;
    public $items = [];
    public $invoice_file; // <--- 3. TAMBAHKAN PROPERTI UNTUK FILE GAMBAR

    public function mount()
    {
        $this->purchase_date = now()->format('Y-m-d');
        $this->po_number = 'PO-' . now()->format('Ymd') . '-' . strtoupper(bin2hex(random_bytes(2)));
        $this->addItem();
    }

    public function addItem()
    {
        $this->items[] = [
            'product_id' => '',
            'quantity_ordered' => 1,
            'price_per_item' => 0,
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function submit()
    {
        // 4. TAMBAHKAN VALIDASI UNTUK GAMBAR NOTA (Opsional/Boleh nullable sesuai struktur migrasi)
        $this->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'invoice_file' => 'nullable|image|max:2048', // Maksimal 2MB (jpg, png, jpeg, dll)
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity_ordered' => 'required|integer|min:1',
            'items.*.price_per_item' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () {
            $user = auth()->user();

            // 5. PROSES UNGGAH GAMBAR KE STORAGE
            $filePath = null;
            if ($this->invoice_file) {
                // Menyimpan ke folder 'invoice_files' di dalam disk 'public'
                $filePath = $this->invoice_file->store('invoice_files', 'public');
            }

            // Hitung total harga dari baris item
            $totalPrice = collect($this->items)->sum(function ($item) {
                return $item['quantity_ordered'] * $item['price_per_item'];
            });

            // 1. Buat Data Induk (Header)
            $purchase = StockPurchase::create([
                'po_number' => $this->po_number,
                'branch_id' => $user->branch_id,
                'supplier_id' => $this->supplier_id,
                'user_id' => $user->id,
                'purchase_date' => $this->purchase_date,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'invoice_file' => $filePath, // <--- 6. SIMPAN PATH GAMBAR KE DATABASE
            ]);

            // 2. Buat Data Anak (Detail Multi-Item)
            foreach ($this->items as $item) {
                StockPurchaseDetail::create([
                    'stock_purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity_ordered' => $item['quantity_ordered'],
                    'quantity_received' => 0,
                    'price_per_item' => $item['price_per_item'],
                ]);
            }

            // 📝 REKAM AUDIT LOG: PENGAJUAN PESANAN STOK BARU (PO MULTI-ITEM)
            AuditLog::create([
                'branch_id' => $user->branch_id,
                'user_id' => $user->id,
                'action' => 'CREATE',
                'description' => "Manager mengajukan Dokumen Pengadaan Multi-Item baru dengan Nomor Kontrak: {$this->po_number} (Taksiran Nilai: Rp " . number_format($totalPrice, 0, ',', '.') . ")."
            ]);
        });

        session()->flash('message', 'Pengajuan pembelian multi-item berhasil dikirim. Menunggu persetujuan Owner.');
        return redirect()->route('manager.stockpurchasehistory');
    }

    public function render()
    {
        return view('livewire.manager.stock-purchase-create', [
            'suppliers' => Supplier::orderBy('name')->get(),
            'products' => Products::orderBy('name')->get(),
        ])->layout('layouts.app');
    }
}