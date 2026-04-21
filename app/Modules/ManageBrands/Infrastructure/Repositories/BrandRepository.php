<?php

namespace App\Modules\ManageBrands\Infrastructure\Repositories;

use App\Models\Brand;
use App\Modules\ManageBrands\Domain\Repositories\ManageBrandRepositoryInterface;
use App\Modules\ManageBrands\Application\DTOs\BrandDTO;

class BrandRepository implements ManageBrandRepositoryInterface
{
    public function find_brand_by_name(string $brandName): ?Brand
    {
        return Brand::where('brand_name', $brandName)->first();
    }

    public function find_brand_by_code(string $brandCode): ?Brand
    {
        return Brand::where('brand_code', $brandCode)->first();
    }

    public function find_brand_by_id(int $brandId): ?Brand
    {
        return Brand::find($brandId);
    }

    public function add_new_brand(BrandDTO $brandDTO): ?Brand
    {
        return Brand::create([
            'brand_name'  => $brandDTO->brandName,
            'brand_code'  => $brandDTO->brandCode,
            'description' => $brandDTO->description,
            'is_active'   => $brandDTO->isActive,
        ]);
    }

    public function update_brand(BrandDTO $brandDTO, int $brandId): ?Brand
    {
        $brand = Brand::find($brandId);
        $brand->brand_name  = $brandDTO->brandName;
        $brand->brand_code  = $brandDTO->brandCode;
        $brand->description = $brandDTO->description;
        $brand->is_active   = $brandDTO->isActive;
        $brand->save();

        return $brand;
    }

    public function delete_brand(int $brandId): ?Brand
    {
        $brand = Brand::find($brandId);
        $brand->deleted_at = date('Y-m-d H:i:s');
        $brand->save();

        return $brand;
    }
}
