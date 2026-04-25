<?php

namespace App\Modules\ManageProducts\Domain\Repositories;

use App\Models\Product;
use App\Modules\ManageProducts\Application\DTOs\ProductDTO;
use Illuminate\Database\Eloquent\Collection;

interface ManageProductRepositoryInterface
{
    public function find_product_by_id(int $productId): ?Product;
    public function find_products_by_brand(int $brandId): Collection;
    public function add_new_product(ProductDTO $productDTO): ?Product;
    public function update_product(ProductDTO $productDTO, int $productId): ?Product;
    public function delete_product(int $productId): ?Product;
}
