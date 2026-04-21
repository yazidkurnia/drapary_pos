<?php

namespace App\Modules\ManageBrands\Domain\Usecases;

use App\Models\Brand;
use App\Modules\ManageBrands\Application\DTOs\BrandDTO;
use App\Modules\ManageBrands\Domain\Repositories\ManageBrandRepositoryInterface;

class CreateManageBrandUsecase
{
    public function __construct(
        private ManageBrandRepositoryInterface $brandRepository
    ) {}

    public function store(BrandDTO $brandDTO): Brand
    {
        return $this->brandRepository->add_new_brand($brandDTO);
    }
}
