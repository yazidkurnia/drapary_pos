<?php

namespace App\Modules\ManageBrands\Domain\Usecases;

use App\Models\Brand;
use App\Modules\ManageBrands\Domain\Repositories\ManageBrandRepositoryInterface;

class DeleteManageBrandUsecase
{
    public function __construct(
        private ManageBrandRepositoryInterface $brandRepository
    ) {}

    public function delete_brand(int $brandId): Brand
    {
        return $this->brandRepository->delete_brand($brandId);
    }
}
