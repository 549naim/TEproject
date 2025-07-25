<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role_list',
            'role_create',
            'role_edit',
            'role_delete',
            'role_permission_edit',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        $user = User::firstOrCreate(
            ['email' => 'superadminuser@gmail.com'],
            [
                'name' => 'SuperAdminsuperadminuser',
                'password' => Hash::make('@superadmin@'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $role = Role::firstOrCreate(['name' => 'SuperAdmin']);

        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole($role);
    }
}
