<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StockLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $types = ['in', 'out', 'expired', 'adjustment'];

        foreach (range(1, 50) as $index) {
            DB::table('stock_logs')->insert([
                'branch_id' => $faker->numberBetween(1, 50),
                'product_id' => $faker->numberBetween(1, 50),
                'user_id' => $faker->numberBetween(1, 50),
                'type' => $faker->randomElement($types),
                'amount' => $faker->numberBetween(1, 20),
                'reason' => $faker->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
