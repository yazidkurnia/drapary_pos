<?php

namespace App\Modules\ManageUnits\Domain\Usecases;

use App\Models\Unit;
use App\Modules\ManageUnits\Application\DTOs\UnitDTO;
use App\Modules\ManageUnits\Domain\Repositories\ManageUnitRepositoryInterface;

class CreateManageUnitUsecase
{
    public function __construct(
        private ManageUnitRepositoryInterface $unitRepository
    ) {}

    public function store(UnitDTO $unitDTO): Unit
    {
        return $this->unitRepository->add_new_unit($unitDTO);
    }
}
