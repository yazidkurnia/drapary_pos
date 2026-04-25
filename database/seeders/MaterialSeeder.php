<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $materials = [
            ['material_name' => 'Katun',          'material_code' => 'KT'],
            ['material_name' => 'Katun Combed',    'material_code' => 'KTC'],
            ['material_name' => 'Katun Bambu',     'material_code' => 'KTB'],
            ['material_name' => 'Polyester',       'material_code' => 'PL'],
            ['material_name' => 'Rayon',           'material_code' => 'RY'],
            ['material_name' => 'Viscose',         'material_code' => 'VS'],
            ['material_name' => 'Linen',           'material_code' => 'LN'],
            ['material_name' => 'Denim',           'material_code' => 'DN'],
            ['material_name' => 'Flannel',         'material_code' => 'FL'],
            ['material_name' => 'Wool',            'material_code' => 'WL'],
            ['material_name' => 'Spandex',         'material_code' => 'SP'],
            ['material_name' => 'Lycra',           'material_code' => 'LY'],
            ['material_name' => 'Sutra',           'material_code' => 'ST'],
            ['material_name' => 'Satin',           'material_code' => 'SA'],
            ['material_name' => 'Velvet',          'material_code' => 'VL'],
            ['material_name' => 'Tweed',           'material_code' => 'TW'],
            ['material_name' => 'Chiffon',         'material_code' => 'CF'],
            ['material_name' => 'Bahan Kaos',      'material_code' => 'BK'],
            ['material_name' => 'Oxford',          'material_code' => 'OX'],
            ['material_name' => 'Drill',           'material_code' => 'DR'],
        ];

        foreach ($materials as $material) {
            DB::table('materials')->insertOrIgnore(array_merge($material, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
