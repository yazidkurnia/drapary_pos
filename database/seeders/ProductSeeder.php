<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            'NKE' => [
                ['product_name' => 'Nike Dri-FIT T-Shirt',        'description' => 'Kaos olahraga teknologi Dri-FIT untuk menyerap keringat dengan cepat.'],
                ['product_name' => 'Nike Sportswear Club Fleece',  'description' => 'Hoodie kasual berbahan fleece yang nyaman untuk sehari-hari.'],
                ['product_name' => 'Nike Air Max Tee',             'description' => 'Kaos grafis koleksi Air Max dengan desain streetwear.'],
                ['product_name' => 'Nike Pro Compression Shorts',  'description' => 'Celana pendek kompresi untuk performa olahraga optimal.'],
                ['product_name' => 'Nike Woven Windrunner Jacket', 'description' => 'Jaket windrunner ringan tahan angin untuk aktivitas outdoor.'],
                ['product_name' => 'Nike Sportswear Polo',         'description' => 'Polo shirt casual dengan logo Swoosh di dada kiri.'],
                ['product_name' => 'Nike Therma Pullover Hoodie',  'description' => 'Hoodie berteknologi Therma untuk menjaga kehangatan saat olahraga.'],
                ['product_name' => 'Nike ACG Long Sleeve',         'description' => 'Kaos lengan panjang koleksi All Conditions Gear.'],
            ],
        ];

        foreach ($products as $brandCode => $items) {
            $brand = Brand::where('brand_code', $brandCode)->first();

            if (!$brand) {
                continue;
            }

            foreach ($items as $item) {
                DB::table('products')->insertOrIgnore(array_merge($item, [
                    'brand_id'   => $brand->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }
}
