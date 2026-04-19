<?php

namespace App\Modules\ManageUnits\Domain\Usecases;

use App\Models\Unit;
use App\Modules\ManageUnits\Application\DTOs\UnitDTO;
use App\Modules\ManageUnits\Domain\Repositories\ManageUnitRepositoryInterface;

class UpdateManageUnitUsecase
{
    public function __construct(
        private ManageUnitRepositoryInterface $unitRepository
    ) {}

    public function update_usecase(UnitDTO $unitDTO, int $unitId): Unit
    {
        return $this->unitRepository->update_unit($unitDTO, $unitId);
    }
}
