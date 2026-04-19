<?php

namespace App\Modules\ManageUnits\Domain\Repositories;

use App\Models\Unit;
use App\Modules\ManageUnits\Application\DTOs\UnitDTO;

interface ManageUnitRepositoryInterface {
    public function find_unit_by_name(string $unitName): ?Unit;

    public function find_unit_by_code(string $unitCode): ?Unit;

    public function find_unit_by_id(int $unitId): ?Unit;

    public function add_new_unit(UnitDTO $unitDTO): ?Unit;

    public function update_unit(UnitDTO $unitDTO, int $unitId): ?Unit;

    public function delete_unit(int $unitId): ?Unit;
}
