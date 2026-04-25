<?php

namespace App\Modules\ManageProductVariants\Domain\Usecases;

use App\Models\ProductVariant;
use App\Modules\ManageProductVariants\Domain\Repositories\ManageProductVariantRepositoryInterface;

class DeleteManageProductVariantUsecase
{
    public function __construct(private ManageProductVariantRepositoryInterface $variantRepository) {}

    public function delete_variant(int $variantId): ProductVariant
    {
        return $this->variantRepository->delete_variant($variantId);
    }
}
