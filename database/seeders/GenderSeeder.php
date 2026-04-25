<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    public function run(): void
    {
        $genders = [
            ['gender_name' => 'Pria',   'gender_code' => 'M'],
            ['gender_name' => 'Wanita', 'gender_code' => 'F'],
            ['gender_name' => 'Unisex', 'gender_code' => 'U'],
            ['gender_name' => 'Anak Laki-laki',   'gender_code' => 'BM'],
            ['gender_name' => 'Anak Perempuan',    'gender_code' => 'BF'],
        ];

        foreach ($genders as $gender) {
            DB::table('genders')->insertOrIgnore(array_merge($gender, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
