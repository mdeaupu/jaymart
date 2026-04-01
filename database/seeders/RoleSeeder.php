<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[Permission::class]->forgetCachedPermissions();
        $permission = Permission::create([
            'name' => 'approve adjustments',
            'guard_name' => 'web'
        ]);

        $owner = Role::create(['name' => 'owner']);
        $manager = Role::create(['name' => 'manager']);
        $supervisor = Role::create(['name' => 'supervisor']);
        $cashier = Role::create(['name' => 'cashier']);
        $warehouse = Role::create(['name' => 'warehouse']);

        $manager->givePermissionTo($permission);
        $owner->givePermissionTo($permission);
    }
}
