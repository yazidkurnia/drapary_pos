<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            ['unit_name' => 'Pcs',   'unit_code' => 'PCS'],
            ['unit_name' => 'Set',   'unit_code' => 'SET'],
            ['unit_name' => 'Lusin', 'unit_code' => 'LSN'],
            ['unit_name' => 'Kodi',  'unit_code' => 'KDI'],
            ['unit_name' => 'Gross', 'unit_code' => 'GRS'],
            ['unit_name' => 'Meter', 'unit_code' => 'MTR'],
            ['unit_name' => 'Yard',  'unit_code' => 'YRD'],
            ['unit_name' => 'Roll',  'unit_code' => 'RLL'],
            ['unit_name' => 'Pasang','unit_code' => 'PSG'],
            ['unit_name' => 'Box',   'unit_code' => 'BOX'],
        ];

        foreach ($units as $unit) {
            DB::table('units')->insertOrIgnore(array_merge($unit, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
