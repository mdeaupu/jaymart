<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        for ($b = 1; $b <= 50; $b++) {
            for ($p = 1; $p <= 10; $p++) {
                DB::table('stocks')->insert([
                    'branch_id' => $b,
                    'product_id' => $p,
                    'quantity' => rand(50, 200),
                    'expired_at' => now()->addDays(10),
                    'low_stock_threshold' => 10,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
