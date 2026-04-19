<?php

namespace App\Modules\ManageSizes\Domain\Usecases;

use App\Models\Size;
use App\Modules\ManageSizes\Application\DTOs\SizeDTO;
use App\Modules\ManageSizes\Domain\Repositories\ManageSizeRepositoryInterface;

class CreateManageSizeUsecase
{
    public function __construct(
        private ManageSizeRepositoryInterface $sizeRepository
    ) {}

    public function store(SizeDTO $sizeDTO): Size
    {
        return $this->sizeRepository->add_new_size($sizeDTO);
    }
}
