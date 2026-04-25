<?php

namespace App\Modules\ManageProductVariants\Infrastructure\Repositories;

use App\Models\ProductVariant;
use App\Modules\ManageProductVariants\Application\DTOs\ProductVariantDTO;
use App\Modules\ManageProductVariants\Domain\Repositories\ManageProductVariantRepositoryInterface;

class ProductVariantRepository implements ManageProductVariantRepositoryInterface
{
    public function find_variant_by_id(int $variantId): ?ProductVariant
    {
        return ProductVariant::find($variantId);
    }

    public function find_variant_by_sku(string $sku): ?ProductVariant
    {
        return ProductVariant::where('sku', $sku)->first();
    }

    public function add_new_variant(ProductVariantDTO $dto): ?ProductVariant
    {
        return ProductVariant::create([
            'product_id'  => $dto->productId,
            'sku'         => $dto->sku,
            'color_id'    => $dto->colorId,
            'size_id'     => $dto->sizeId,
            'material_id' => $dto->materialId,
            'fit_id'      => $dto->fitId,
            'sleeve_id'   => $dto->sleeveId,
            'collar_id'   => $dto->collarId,
            'pattern_id'  => $dto->patternId,
            'gender_id'   => $dto->genderId,
            'unit_id'     => $dto->unitId,
            'price'       => $dto->price,
            'stock'       => $dto->stock,
        ]);
    }

    public function update_variant(ProductVariantDTO $dto, int $variantId): ?ProductVariant
    {
        $variant = ProductVariant::find($variantId);
        $variant->product_id  = $dto->productId;
        $variant->sku         = $dto->sku;
        $variant->color_id    = $dto->colorId;
        $variant->size_id     = $dto->sizeId;
        $variant->material_id = $dto->materialId;
        $variant->fit_id      = $dto->fitId;
        $variant->sleeve_id   = $dto->sleeveId;
        $variant->collar_id   = $dto->collarId;
        $variant->pattern_id  = $dto->patternId;
        $variant->gender_id   = $dto->genderId;
        $variant->unit_id     = $dto->unitId;
        $variant->price       = $dto->price;
        $variant->stock       = $dto->stock;
        $variant->save();

        return $variant;
    }

    public function delete_variant(int $variantId): ?ProductVariant
    {
        $variant = ProductVariant::find($variantId);
        $variant->deleted_at = date('Y-m-d H:i:s');
        $variant->save();

        return $variant;
    }
}
