<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SleeveSeeder extends Seeder
{
    public function run(): void
    {
        $sleeves = [
            ['sleeve_name' => 'Lengan Pendek',  'sleeve_code' => 'LP'],
            ['sleeve_name' => 'Lengan Panjang',  'sleeve_code' => 'LPJ'],
            ['sleeve_name' => 'Lengan 3/4',      'sleeve_code' => 'L34'],
            ['sleeve_name' => 'Tanpa Lengan',    'sleeve_code' => 'TL'],
            ['sleeve_name' => 'Lengan Balon',    'sleeve_code' => 'LB'],
            ['sleeve_name' => 'Lengan Raglan',   'sleeve_code' => 'LR'],
            ['sleeve_name' => 'Lengan Sayap',    'sleeve_code' => 'LS'],
            ['sleeve_name' => 'Lengan Kimono',   'sleeve_code' => 'LK'],
        ];

        foreach ($sleeves as $sleeve) {
            DB::table('sleeves')->insertOrIgnore(array_merge($sleeve, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
