<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('branches')->insert([
            ['name' => 'Pusat Jakarta', 'address' => 'Jl. Sudirman No. 1', 'created_at' => now()],
            ['name' => 'Cabang Bandung', 'address' => 'Jl. Asia Afrika No. 10', 'created_at' => now()],
        ]);
    }
}
