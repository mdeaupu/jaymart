<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        $branches = DB::table('branches')->get();
        $products = DB::table('products')->get();

        foreach ($branches as $branch) {
            foreach ($products as $product) {
                // Buat stok acak antara 5 sampai 100
                // Jika dapet angka kecil, dia akan muncul di "Stok Kritis"
                $qty = rand(5, 50);

                DB::table('stocks')->insert([
                    'branch_id' => $branch->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'low_stock_threshold' => 15, // Kita set 15 agar angka di bawah itu jadi kritis
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
