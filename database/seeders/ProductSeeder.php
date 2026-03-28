<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            ['name' => 'Kopi Susu Gula Aren', 'sell_price' => 25000, 'created_at' => now()],
            ['name' => 'Roti Bakar Cokelat', 'sell_price' => 15000, 'created_at' => now()],
            ['name' => 'Es Teh Manis', 'sell_price' => 5000, 'created_at' => now()],
        ]);
    }
}
