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

        $manager = User::create([
            'name' => 'Asep',
            'email' => 'asep@gmail.com',
            'password' => Hash::make('asepasep'),
            'branch_id' => 1,
        ]);
        $manager->assignRole('manager');

        $supervisor = User::create([
            'name' => 'Ujang',
            'email' => 'ujang@gmail.com',
            'password' => Hash::make('ujangujang'),
            'branch_id' => 1,
        ]);
        $supervisor->assignRole('supervisor');

        $cashier = User::create([
            'name' => 'Mila',
            'email' => 'mila@gmail.com',
            'password' => Hash::make('milamila'),
            'branch_id' => 1,
        ]);
        $cashier->assignRole('cashier');

        $warehouse = User::create([
            'name' => 'Dadang',
            'email' => 'dadang@gmail.com',
            'password' => Hash::make('dadangdadang'),
            'branch_id' => 1,
        ]);
        $warehouse->assignRole('warehouse');

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
