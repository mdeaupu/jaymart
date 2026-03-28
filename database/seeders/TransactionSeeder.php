<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = DB::table('users')->first();
        $product = DB::table('products')->first();
        $txId = DB::table('transactions')->insertGetId([
            'branch_id' => $user->branch_id,
            'user_id' => $user->id,
            'invoice_number' => 'INV-' . time(),
            'total_price' => 50000,
            'created_at' => now(),
            ]);
            
        DB::table('transactions_details')->insert([
            'transaction_id' => $txId,
            'product_id' => $product->id,
            'qty' => 2,
            'price_at_transaction' => 25000,
            'created_at' => now(),
        ]);
    }
}
