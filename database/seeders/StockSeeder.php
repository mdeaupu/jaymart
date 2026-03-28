<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = DB::table('branches')->get();
        $products = DB::table('products')->get();
        
        foreach ($branches as $branch) {
            foreach ($products as $product) {
                DB::table('stocks')->insert([
                    'branch_id' => $branch->id,
                    'product_id' => $product->id,
                    'quantity' => 100,
                    'low_stock_threshold' => 10,
                    'created_at' => now(),
                ]);
            }
        }
    }
}
