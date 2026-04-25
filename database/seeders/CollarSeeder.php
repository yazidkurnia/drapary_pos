<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollarSeeder extends Seeder
{
    public function run(): void
    {
        $collars = [
            ['collar_name' => 'Crew Neck',     'collar_code' => 'CN'],
            ['collar_name' => 'V-Neck',         'collar_code' => 'VN'],
            ['collar_name' => 'Polo',           'collar_code' => 'PL'],
            ['collar_name' => 'Turtleneck',     'collar_code' => 'TN'],
            ['collar_name' => 'Hoodie',         'collar_code' => 'HD'],
            ['collar_name' => 'Henley',         'collar_code' => 'HN'],
            ['collar_name' => 'Kerah Kemeja',   'collar_code' => 'KK'],
            ['collar_name' => 'Kerah Mandarin', 'collar_code' => 'KM'],
            ['collar_name' => 'Scoop Neck',     'collar_code' => 'SC'],
            ['collar_name' => 'Off Shoulder',   'collar_code' => 'OF'],
        ];

        foreach ($collars as $collar) {
            DB::table('collars')->insertOrIgnore(array_merge($collar, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
