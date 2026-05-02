<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            ColorSeeder::class,
            UnitSeeder::class,
            SizeSeeder::class,
            MaterialSeeder::class,
            FitSeeder::class,
            SleeveSeeder::class,
            CollarSeeder::class,
            PatternSeeder::class,
            GenderSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
