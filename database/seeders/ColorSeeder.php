<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            ['color_name' => 'Hitam',       'hexa_code' => '#000000', 'is_active' => true],
            ['color_name' => 'Putih',        'hexa_code' => '#FFFFFF', 'is_active' => true],
            ['color_name' => 'Abu-abu',      'hexa_code' => '#808080', 'is_active' => true],
            ['color_name' => 'Merah',        'hexa_code' => '#FF0000', 'is_active' => true],
            ['color_name' => 'Merah Marun',  'hexa_code' => '#800000', 'is_active' => true],
            ['color_name' => 'Biru',         'hexa_code' => '#0000FF', 'is_active' => true],
            ['color_name' => 'Biru Navy',    'hexa_code' => '#001F5B', 'is_active' => true],
            ['color_name' => 'Biru Muda',    'hexa_code' => '#ADD8E6', 'is_active' => true],
            ['color_name' => 'Hijau',        'hexa_code' => '#008000', 'is_active' => true],
            ['color_name' => 'Hijau Army',   'hexa_code' => '#4B5320', 'is_active' => true],
            ['color_name' => 'Hijau Tosca',  'hexa_code' => '#008080', 'is_active' => true],
            ['color_name' => 'Kuning',       'hexa_code' => '#FFFF00', 'is_active' => true],
            ['color_name' => 'Kuning Mustard','hexa_code' => '#FFDB58', 'is_active' => true],
            ['color_name' => 'Oranye',       'hexa_code' => '#FFA500', 'is_active' => true],
            ['color_name' => 'Pink',         'hexa_code' => '#FFC0CB', 'is_active' => true],
            ['color_name' => 'Pink Fanta',   'hexa_code' => '#FF007F', 'is_active' => true],
            ['color_name' => 'Ungu',         'hexa_code' => '#800080', 'is_active' => true],
            ['color_name' => 'Cokelat',      'hexa_code' => '#A52A2A', 'is_active' => true],
            ['color_name' => 'Cream',        'hexa_code' => '#FFFDD0', 'is_active' => true],
            ['color_name' => 'Salem',        'hexa_code' => '#FA8072', 'is_active' => true],
        ];

        foreach ($colors as $color) {
            DB::table('colors')->insertOrIgnore(array_merge($color, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
