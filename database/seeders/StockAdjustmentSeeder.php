<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockAdjustmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = DB::table('users')->first();
        $product = DB::table('products')->where('name', 'Es Teh Manis')->first();
        
        DB::table('stock_adjustments')->insert([
            'branch_id' => $user->branch_id,
            'product_id' => $product->id,
            'user_id' => $user->id,
            'old_quantity' => 100,
            'new_quantity' => 95,
            'adjustment_amount' => -5,
            'reason' => 'Gelas pecah/tumpah',
            'status' => 'approved',
            'approved_by' => $user->id,
            'created_at' => now(),
        ]);
    }
}
