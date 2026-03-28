<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branchId = DB::table('branches')->first()->id;
        DB::table('users')->insert([
            'name' => 'Admin Toko',
            'email' => 'admin@toko.com',
            'password' => Hash::make('password'),
            'branch_id' => $branchId,
            'created_at' => now(),
        ]);

        $owner = User::create([
            'name' => 'Pak Jayusman',
            'email' => 'owner@jaymart.com',
            'password' => Hash::make('password123'),
        ]);

        $owner->assignRole('owner');
    }
}
