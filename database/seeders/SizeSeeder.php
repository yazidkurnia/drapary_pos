<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = [
            // Ukuran huruf (pakaian atas)
            ['size_name' => 'XS',  'size_code' => 'XS'],
            ['size_name' => 'S',   'size_code' => 'S'],
            ['size_name' => 'M',   'size_code' => 'M'],
            ['size_name' => 'L',   'size_code' => 'L'],
            ['size_name' => 'XL',  'size_code' => 'XL'],
            ['size_name' => 'XXL', 'size_code' => '2XL'],
            ['size_name' => '3XL', 'size_code' => '3XL'],
            ['size_name' => '4XL', 'size_code' => '4XL'],
            // Ukuran angka (celana/rok)
            ['size_name' => '26',  'size_code' => '26'],
            ['size_name' => '27',  'size_code' => '27'],
            ['size_name' => '28',  'size_code' => '28'],
            ['size_name' => '29',  'size_code' => '29'],
            ['size_name' => '30',  'size_code' => '30'],
            ['size_name' => '31',  'size_code' => '31'],
            ['size_name' => '32',  'size_code' => '32'],
            ['size_name' => '33',  'size_code' => '33'],
            ['size_name' => '34',  'size_code' => '34'],
            ['size_name' => '36',  'size_code' => '36'],
            ['size_name' => '38',  'size_code' => '38'],
            ['size_name' => '40',  'size_code' => '40'],
            // All size
            ['size_name' => 'All Size', 'size_code' => 'AS'],
        ];

        foreach ($sizes as $size) {
            DB::table('sizes')->insertOrIgnore(array_merge($size, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
