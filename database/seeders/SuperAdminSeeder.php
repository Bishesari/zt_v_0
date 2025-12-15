<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // اطمینان از وجود نقش
        $role = Role::where('name', 'super_admin')->first();

        if (! $role) {
            throw new \Exception('Role super_admin not found. Run RolePermissionSeeder first.');
        }

        // ساخت یا دریافت کاربر
        $user = User::firstOrCreate(
            ['user_name' => 'superadmin'],
            [
                'password'  => '12345678',
                'is_active' => true,
            ]
        );

        // اختصاص نقش
        if (! $user->hasRole('super_admin')) {
            $user->assignRole('super_admin');
        }
    }
}
