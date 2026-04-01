<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StockAdjustmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 50; $i++) {
            $oldQty = $faker->numberBetween(50, 100);
            $adjAmount = $faker->numberBetween(-20, 20);

            DB::table('stock_adjustments')->insert([
                'branch_id' => $faker->numberBetween(1, 50),
                'product_id' => $faker->numberBetween(1, 50),
                'user_id' => $faker->numberBetween(1, 50),
                'old_quantity' => $oldQty,
                'adjustment_amount' => $adjAmount,
                'new_quantity' => $oldQty + $adjAmount,
                'reason' => $faker->sentence(),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
