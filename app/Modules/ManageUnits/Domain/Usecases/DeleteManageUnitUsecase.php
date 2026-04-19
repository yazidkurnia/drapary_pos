<?php

namespace App\Modules\ManageUnits\Domain\Usecases;

use App\Models\Unit;
use App\Modules\ManageUnits\Domain\Repositories\ManageUnitRepositoryInterface;

class DeleteManageUnitUsecase
{
    public function __construct(
        private ManageUnitRepositoryInterface $unitRepository
    ) {}

    public function delete_unit(int $unitId): Unit
    {
        return $this->unitRepository->delete_unit($unitId);
    }
}
