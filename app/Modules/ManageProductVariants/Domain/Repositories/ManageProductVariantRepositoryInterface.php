<?php

namespace App\Modules\ManageProductVariants\Domain\Repositories;

use App\Models\ProductVariant;
use App\Modules\ManageProductVariants\Application\DTOs\ProductVariantDTO;

interface ManageProductVariantRepositoryInterface
{
    public function find_variant_by_id(int $variantId): ?ProductVariant;
    public function find_variant_by_sku(string $sku): ?ProductVariant;
    public function add_new_variant(ProductVariantDTO $dto): ?ProductVariant;
    public function update_variant(ProductVariantDTO $dto, int $variantId): ?ProductVariant;
    public function delete_variant(int $variantId): ?ProductVariant;
}
