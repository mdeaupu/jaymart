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
            'name' => 'Jayusman',
            'email' => 'jayusman@gmail.com',
            'password' => Hash::make('jayusman'),
        ]);

        $owner->assignRole('owner');
    }
}
