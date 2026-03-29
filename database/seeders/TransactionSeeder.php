<?php

namespace Database\Seeders;

use App\Models\Branches;
use App\Models\Products;
use App\Models\Transactions;
use App\Models\TransactionsDetail;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $branches = Branches::all();
        $products = Products::all();
        $cashier = User::first(); // Pastikan ada user untuk relasi user_id

        foreach ($branches as $branch) {
            // Buat 15-20 transaksi per cabang agar grafik bervariasi
            for ($i = 0; $i < rand(15, 20); $i++) {

                // Buat tanggal acak dalam 30 hari terakhir
                $randomDate = Carbon::now()->subDays(rand(0, 30));

                $transaction = Transactions::create([
                    'branch_id' => $branch->id,
                    'user_id' => $cashier->id,
                    'invoice_number' => 'INV-' . strtoupper(bin2hex(random_bytes(4))),
                    'total_price' => 0, // Akan diupdate setelah detail dibuat
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate,
                ]);

                $totalPrice = 0;

                // Tiap transaksi beli 1-3 jenis barang acak
                $selectedProducts = $products->random(rand(1, 3));

                foreach ($selectedProducts as $product) {
                    $qty = rand(1, 5);
                    $subTotal = $product->sell_price * $qty;

                    TransactionsDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $product->id,
                        'qty' => $qty,
                        'price_at_transaction' => $product->sell_price,
                        'created_at' => $randomDate,
                        'updated_at' => $randomDate,
                    ]);

                    $totalPrice += $subTotal;
                }

                // Update total harga transaksi
                $transaction->update(['total_price' => $totalPrice]);
            }
        }
    }
}
