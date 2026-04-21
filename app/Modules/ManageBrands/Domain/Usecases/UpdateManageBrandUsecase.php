<?php

namespace App\Modules\ManageBrands\Domain\Usecases;

use App\Models\Brand;
use App\Modules\ManageBrands\Application\DTOs\BrandDTO;
use App\Modules\ManageBrands\Domain\Repositories\ManageBrandRepositoryInterface;

class UpdateManageBrandUsecase
{
    public function __construct(
        private ManageBrandRepositoryInterface $brandRepository
    ) {}

    public function update_usecase(BrandDTO $brandDTO, int $brandId): Brand
    {
        return $this->brandRepository->update_brand($brandDTO, $brandId);
    }
}
