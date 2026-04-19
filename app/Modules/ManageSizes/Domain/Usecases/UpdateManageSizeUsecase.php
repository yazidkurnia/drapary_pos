<?php

namespace App\Modules\ManageSizes\Domain\Usecases;

use App\Models\Size;
use App\Modules\ManageSizes\Application\DTOs\SizeDTO;
use App\Modules\ManageSizes\Domain\Repositories\ManageSizeRepositoryInterface;

class UpdateManageSizeUsecase
{
    public function __construct(
        private ManageSizeRepositoryInterface $sizeRepository
    ) {}

    public function update_usecase(SizeDTO $sizeDTO, int $sizeId): Size
    {
        return $this->sizeRepository->update_size($sizeDTO, $sizeId);
    }
}
