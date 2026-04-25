<?php

namespace App\Modules\ManageProductVariants\Domain\Usecases;

use App\Models\ProductVariant;
use App\Modules\ManageProductVariants\Application\DTOs\ProductVariantDTO;
use App\Modules\ManageProductVariants\Domain\Repositories\ManageProductVariantRepositoryInterface;

class CreateManageProductVariantUsecase
{
    public function __construct(private ManageProductVariantRepositoryInterface $variantRepository) {}

    public function store(ProductVariantDTO $dto): ProductVariant
    {
        return $this->variantRepository->add_new_variant($dto);
    }
}
