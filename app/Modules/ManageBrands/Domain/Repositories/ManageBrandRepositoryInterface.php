<?php

namespace App\Modules\ManageBrands\Domain\Repositories;

use App\Models\Brand;
use App\Modules\ManageBrands\Application\DTOs\BrandDTO;

interface ManageBrandRepositoryInterface {
    public function find_brand_by_name(string $brandName): ?Brand;

    public function find_brand_by_code(string $brandCode): ?Brand;

    public function find_brand_by_id(int $brandId): ?Brand;

    public function add_new_brand(BrandDTO $brandDTO): ?Brand;

    public function update_brand(BrandDTO $brandDTO, int $brandId): ?Brand;

    public function delete_brand(int $brandId): ?Brand;
}
