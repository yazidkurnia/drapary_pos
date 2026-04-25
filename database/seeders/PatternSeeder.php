<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatternSeeder extends Seeder
{
    public function run(): void
    {
        $patterns = [
            ['pattern_name' => 'Polos',          'pattern_code' => 'PLO'],
            ['pattern_name' => 'Stripe',          'pattern_code' => 'STR'],
            ['pattern_name' => 'Kotak-kotak',     'pattern_code' => 'KTK'],
            ['pattern_name' => 'Floral',          'pattern_code' => 'FLR'],
            ['pattern_name' => 'Camouflage',      'pattern_code' => 'CMF'],
            ['pattern_name' => 'Polkadot',        'pattern_code' => 'PKD'],
            ['pattern_name' => 'Abstrak',         'pattern_code' => 'ABS'],
            ['pattern_name' => 'Animal Print',    'pattern_code' => 'ANP'],
            ['pattern_name' => 'Batik',           'pattern_code' => 'BTK'],
            ['pattern_name' => 'Tie Dye',         'pattern_code' => 'TDY'],
            ['pattern_name' => 'Gradasi',         'pattern_code' => 'GRD'],
            ['pattern_name' => 'Geometric',       'pattern_code' => 'GEO'],
        ];

        foreach ($patterns as $pattern) {
            DB::table('patterns')->insertOrIgnore(array_merge($pattern, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
