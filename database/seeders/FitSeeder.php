<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FitSeeder extends Seeder
{
    public function run(): void
    {
        $fits = [
            ['fit_name' => 'Regular Fit',  'fit_code' => 'RF'],
            ['fit_name' => 'Slim Fit',     'fit_code' => 'SF'],
            ['fit_name' => 'Oversize',     'fit_code' => 'OS'],
            ['fit_name' => 'Loose Fit',    'fit_code' => 'LF'],
            ['fit_name' => 'Skinny Fit',   'fit_code' => 'SK'],
            ['fit_name' => 'Straight Fit', 'fit_code' => 'ST'],
            ['fit_name' => 'Relaxed Fit',  'fit_code' => 'RX'],
            ['fit_name' => 'Bodycon',      'fit_code' => 'BC'],
            ['fit_name' => 'Boxy',         'fit_code' => 'BX'],
        ];

        foreach ($fits as $fit) {
            DB::table('fits')->insertOrIgnore(array_merge($fit, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
