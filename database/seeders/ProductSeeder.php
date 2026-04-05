<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        foreach (range(1, 50) as $index) {
            DB::table('products')->insert([
                'name' => $faker->words(2, true),
                'sell_price' => $faker->numberBetween(5000, 500000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
