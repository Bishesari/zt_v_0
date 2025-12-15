<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ManagerSeeder extends Seeder
{
    public function run(): void
    {
        // اطمینان از وجود نقش manager
        $role = Role::where('name', 'manager')->first();

        if (! $role) {
            throw new \Exception('Role manager not found. Run RolePermissionSeeder first.');
        }

        // ساخت یا دریافت کاربر مدیر
        $user = User::firstOrCreate(
            ['user_name' => 'manager'],
            [
                'password'  => Hash::make('12345678'),
                'is_active' => true,
            ]
        );

        // اختصاص نقش manager
        if (! $user->hasRole('manager')) {
            $user->assignRole('manager');
        }
    }
}
