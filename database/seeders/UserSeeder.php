<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $owner = User::firstOrCreate(
            ['email' => 'owner@pos.com'],
            [
                'name'     => 'Owner POS',
                'password' => Hash::make('password'),
            ]
        );
        $owner->syncRoles(['Owner']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@pos.com'],
            [
                'name'     => 'Admin Ecommerce',
                'password' => Hash::make('password'),
            ]
        );
        $admin->syncRoles(['Admin Ecommerce']);

        $kepala = User::firstOrCreate(
            ['email' => 'kepala@pos.com'],
            [
                'name'     => 'Kepala Toko',
                'password' => Hash::make('password'),
            ]
        );
        $kepala->syncRoles(['Kepala Toko']);

        $kasir = User::firstOrCreate(
            ['email' => 'kasir@pos.com'],
            [
                'name'     => 'Kasir',
                'password' => Hash::make('password'),
            ]
        );
        $kasir->syncRoles(['Kasir']);
    }
}
