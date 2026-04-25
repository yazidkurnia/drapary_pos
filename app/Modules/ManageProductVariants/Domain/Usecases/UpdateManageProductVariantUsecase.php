<?php

namespace App\Modules\ManageProductVariants\Domain\Usecases;

use App\Models\ProductVariant;
use App\Modules\ManageProductVariants\Application\DTOs\ProductVariantDTO;
use App\Modules\ManageProductVariants\Domain\Repositories\ManageProductVariantRepositoryInterface;

class UpdateManageProductVariantUsecase
{
    public function __construct(private ManageProductVariantRepositoryInterface $variantRepository) {}

    public function update_usecase(ProductVariantDTO $dto, int $variantId): ProductVariant
    {
        return $this->variantRepository->update_variant($dto, $variantId);
    }
}
