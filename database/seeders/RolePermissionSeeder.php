<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'users.view',
            'users.create',
            'users.update',
            'users.deactivate',

            'drivers.view',
            'drivers.create',
            'drivers.update',
            'drivers.deactivate',

            'charges.view',
            'charges.create',

            'payments.create',
            'payments.view',

            'settings.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $manager    = Role::firstOrCreate(['name' => 'manager']);
        $secretary  = Role::firstOrCreate(['name' => 'secretary']);
        $driver     = Role::firstOrCreate(['name' => 'driver']);

        // Super Admin → همه دسترسی‌ها
        $superAdmin->syncPermissions(Permission::all());

        // Manager
        $manager->syncPermissions([
            'users.view',
            'users.create',
            'users.update',

            'drivers.view',
            'drivers.create',
            'drivers.update',
            'drivers.deactivate',

            'charges.view',
            'charges.create',

            'payments.view',
        ]);

        // Secretary
        $secretary->syncPermissions([
            'drivers.view',
            'payments.create',
            'payments.view',
        ]);

        // Driver
        $driver->syncPermissions([
            'charges.view',
            'payments.view',
        ]);
    }
}
