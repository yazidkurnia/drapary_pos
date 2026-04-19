<?php

namespace App\Modules\ManageSizes\Domain\Usecases;

use App\Models\Size;
use App\Modules\ManageSizes\Domain\Repositories\ManageSizeRepositoryInterface;

class DeleteManageSizeUsecase
{
    public function __construct(
        private ManageSizeRepositoryInterface $sizeRepository
    ) {}

    public function delete_size(int $sizeId): Size
    {
        return $this->sizeRepository->delete_size($sizeId);
    }
}
