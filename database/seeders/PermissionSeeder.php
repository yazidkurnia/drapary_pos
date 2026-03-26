<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Dashboard
            'view dashboard',
            // POS
            'access pos',
            // Transactions
            'view transactions',
            // Products
            'manage products',
            // Users
            'manage users',
            // Roles & Permissions
            'manage roles',
            // Reports
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign default permissions per role
        $rolePermissions = [
            'Owner' => $permissions, // semua permission
            'Admin Ecommerce' => [
                'view dashboard',
                'access pos',
                'view transactions',
                'manage products',
                'manage users',
                'view reports',
            ],
            'Kepala Toko' => [
                'view dashboard',
                'access pos',
                'view transactions',
                'manage products',
                'view reports',
            ],
            'Kasir' => [
                'view dashboard',
                'access pos',
                'view transactions',
            ],
        ];

        foreach ($rolePermissions as $roleName => $perms) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $role->syncPermissions($perms);
            }
        }
    }
}
