<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner = User::create([
            'name' => 'Jayusman',
            'email' => 'jayusman@gmail.com',
            'password' => Hash::make('jayusman'),
        ]);
        $owner->assignRole('owner');

        $faker = Faker::create('id_ID');
        for ($i = 0; $i < 50; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'branch_id' => $faker->numberBetween(1, 50),
            ]);

            $user->assignRole($faker->randomElement(['manager', 'supervisor', 'cashier', 'warehouse']));
        }


    }
}
