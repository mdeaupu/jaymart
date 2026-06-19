<?php

namespace App\Livewire\Cashier;

use Livewire\Component;
use App\Models\Products;
use App\Models\Stocks;
use App\Models\Transactions;
use App\Models\TransactionsDetail;
use App\Models\CashierCorrections;
use Illuminate\Support\Facades\DB;

class Pos extends Component
{
    public $search = '';
    public $cart = [];
    public $total = 0;

    // State Properti untuk Fitur Koreksi Void Berjenjang
    public $selected_detail_id;
    public $wrong_qty;
    public $correct_qty;
    public $reason;
    public $showCorrectionModal = false;

    protected function rules()
    {
        return [
            'correct_qty' => 'required|integer|min:0',
            'reason' => 'required|string|min:5',
        ];
    }

    protected $validationAttributes = [
        'correct_qty' => 'Kuantitas Koreksi Fisik',
        'reason' => 'Alasan Salah Input',
    ];

    public function addToCart($id)
    {
        $branchId = auth()->user()->branch_id;

        // 🔒 KEAMANAN: Cari produk yang memang memiliki record stok di cabang aktif kasir
        $product = Products::whereHas('stocks', function ($q) use ($branchId) {
            $q->where('branch_id', $branchId);
        })->find($id);

        if (!$product) {
            session()->flash('error', 'Produk tidak ditemukan di cabang ini.');
            return;
        }

        // Ambil stok spesifik untuk cabang ini
        $stockModel = Stocks::where('product_id', $id)->where('branch_id', $branchId)->first();
        $stock = $stockModel ? $stockModel->quantity : 0;
        $currentQty = $this->cart[$id]['qty'] ?? 0;

        if ($currentQty >= $stock) {
            session()->flash('error', 'Stok di cabang Anda habis!');
            return;
        }

        if (isset($this->cart[$id])) {
            $this->cart[$id]['qty']++;
        } else {
            $this->cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->sell_price,
                'qty' => 1,
            ];
        }

        $this->calculateTotal();
    }

    public function decreaseQty($id)
    {
        if (isset($this->cart[$id])) {
            $this->cart[$id]['qty']--;

            if ($this->cart[$id]['qty'] <= 0) {
                unset($this->cart[$id]);
            }
        }

        $this->calculateTotal();
    }

    public function increaseQty($id)
    {
        $branchId = auth()->user()->branch_id;
        $stockModel = Stocks::where('product_id', $id)->where('branch_id', $branchId)->first();
        $stock = $stockModel ? $stockModel->quantity : 0;
        $currentQty = $this->cart[$id]['qty'] ?? 0;

        if ($currentQty >= $stock) {
            session()->flash('error', 'Stok cabang tidak mencukupi untuk menambah jumlah!');
            return;
        }

        $this->cart[$id]['qty']++;
        $this->calculateTotal();
    }

    public function removeFromCart($id)
    {
        unset($this->cart[$id]);
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['qty'];
        });
    }

    private function getShift()
    {
        // Menggunakan now()->hour agar konsisten dengan Carbon Laravel
        $hour = now()->hour;

        if ($hour >= 6 && $hour < 14) {
            return 'Pagi';
        } elseif ($hour >= 14 && $hour < 18) { // <-- Diubah dari 22 menjadi 18
            return 'Siang';
        } else {
            return 'Malam';
        }
    }

    public function checkout()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'Keranjang belanja masih kosong!');
            return;
        }

        $branchId = auth()->user()->branch_id;
        if (!$branchId) {
            session()->flash('error', 'Gagal memproses. Akun Anda belum didaftarkan ke cabang manapun.');
            return;
        }

        $transaction = null;

        DB::transaction(function () use (&$transaction, $branchId) {
            $invoiceNumber = 'TRX-' . time() . '-' . rand(100, 999);

            // 1. Validasi ulang ketersediaan seluruh item di dalam cart sebelum memotong database
            foreach ($this->cart as $item) {
                $stockCheck = Stocks::where('product_id', $item['id'])
                    ->where('branch_id', $branchId)
                    ->lockForUpdate()
                    ->first();

                if (!$stockCheck || $stockCheck->quantity < $item['qty']) {
                    throw new \Exception("Stok untuk produk '{$item['name']}' tidak mencukupi atau habis saat checkout dilakukan.");
                }
            }

            // 2. Simpan header transaksi dengan mengunci branch_id asli kasir
            $transaction = Transactions::create([
                'branch_id' => $branchId,
                'user_id' => auth()->id(),
                'invoice_number' => $invoiceNumber,
                'total_price' => $this->total,
                'shift' => $this->getShift()
            ]);

            foreach ($this->cart as $item) {
                TransactionsDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['id'],
                    'qty' => $item['qty'],
                    'price_at_transaction' => $item['price'],
                ]);

                // 3. Potong stok harian produk spesifik cabang kasir aktif secara akurat
                Stocks::where('product_id', $item['id'])
                    ->where('branch_id', $branchId)
                    ->decrement('quantity', $item['qty']);
            }
        });

        $this->cart = [];
        $this->total = 0;

        session()->flash('success', 'Transaksi berhasil disimpan!');
        $this->dispatch('print-receipt', ['url' => route('cashier.receipt', ['transaction' => $transaction->id])]);
    }

    public function openCorrection($detailId)
    {
        $detail = TransactionsDetail::findOrFail($detailId);
        $this->selected_detail_id = $detailId;
        $this->wrong_qty = $detail->qty;
        $this->correct_qty = '';
        $this->reason = '';
        $this->showCorrectionModal = true;
    }

    public function submitCorrectionRequest()
    {
        $this->validate();

        $detail = TransactionsDetail::findOrFail($this->selected_detail_id);
        $transaction = Transactions::findOrFail($detail->transaction_id);
        $branchId = auth()->user()->branch_id;

        if ($this->correct_qty >= $this->wrong_qty) {
            session()->flash('error', 'Jumlah koreksi baru harus lebih sedikit dari jumlah transaksi awal (Pengurangan/Void Barang).');
            return;
        }

        $qtyDiff = $this->wrong_qty - $this->correct_qty;
        $financialImpact = $qtyDiff * $detail->price_at_transaction;

        // 🔒 AMAN: Mengirimkan berkas koreksi terikat dengan branch_id kasir agar muncul di dashboard SPV cabang terkait
        CashierCorrections::create([
            'branch_id' => $branchId,
            'transaction_id' => $transaction->id,
            'product_id' => $detail->product_id,
            'user_id' => auth()->id(),
            'wrong_quantity' => $this->wrong_qty,
            'corrected_quantity' => $this->correct_qty,
            'quantity_difference' => $qtyDiff,
            'financial_impact' => $financialImpact,
            'reason' => 'KASIR MISMATCH: ' . $this->reason,
            'status' => 'pending'
        ]);

        $this->showCorrectionModal = false;
        session()->flash('success', 'Aduan koreksi struk telah diajukan ke dasbor Supervisor cabang.');
    }

    public function render()
    {
        $branchId = auth()->user()->branch_id;

        // Tampilkan produk yang hanya terdaftar/memiliki entitas stok di cabang milik kasir
        $products = Products::whereHas('stocks', function ($q) use ($branchId) {
            $q->where('branch_id', $branchId);
        })
            ->where('name', 'like', '%' . $this->search . '%')
            ->get();

        $lastTransaction = Transactions::with(['details.product'])
            ->where('user_id', auth()->id())
            ->where('branch_id', $branchId)
            ->latest()
            ->first();

        return view('livewire.cashier.pos', [
            'products' => $products,
            'lastTransaction' => $lastTransaction
        ])->layout('layouts.app');
    }
}