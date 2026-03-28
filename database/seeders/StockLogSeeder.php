<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = DB::table('users')->first();
        $product = DB::table('products')->first();
        
        DB::table('stock_logs')->insert([
            'branch_id' => $user->branch_id,
            'product_id' => $product->id,
            'user_id' => $user->id,
            'type' => 'in',
            'amount' => 50,
            'reason' => 'Restock mingguan',
            'created_at' => now(),
        ]);
    }
}
