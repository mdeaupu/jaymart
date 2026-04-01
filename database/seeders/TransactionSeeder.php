<?php

namespace Database\Seeders;

use App\Models\Transactions;
use App\Models\TransactionsDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        foreach (range(1, 50) as $index) {
            $transaction = Transactions::create([
                'branch_id' => $faker->numberBetween(1, 50),
                'user_id' => $faker->numberBetween(1, 50),
                'invoice_number' => 'INV-' . strtoupper($faker->bothify('??###')),
                'total_price' => 0,
            ]);

            $totalRunning = 0;

            foreach (range(1, rand(1, 3)) as $d) {
                $qty = $faker->numberBetween(1, 5);
                $price = $faker->numberBetween(10000, 100000);
                $subtotal = $qty * $price;

                TransactionsDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $faker->numberBetween(1, 50),
                    'qty' => $qty,
                    'price_at_transaction' => $price,
                ]);

                $totalRunning += $subtotal;
            }

            $transaction->update(['total_price' => $totalRunning]);
        }
    }
}
