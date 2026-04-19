<?php

namespace App\Modules\ManageUnits\Infrastructure\Repositories;

use App\Models\Unit;
use App\Modules\ManageUnits\Domain\Repositories\ManageUnitRepositoryInterface;
use App\Modules\ManageUnits\Application\DTOs\UnitDTO;

class UnitRepository implements ManageUnitRepositoryInterface
{
    public function find_unit_by_name(string $unitName): ?Unit
    {
        return Unit::where('unit_name', $unitName)->first();
    }

    public function find_unit_by_code(string $unitCode): ?Unit
    {
        return Unit::where('unit_code', $unitCode)->first();
    }

    public function find_unit_by_id(int $unitId): ?Unit
    {
        return Unit::find($unitId);
    }

    public function add_new_unit(UnitDTO $unitDTO): ?Unit
    {
        return Unit::create([
            'unit_name' => $unitDTO->unitName,
            'unit_code' => $unitDTO->unitCode,
        ]);
    }

    public function update_unit(UnitDTO $unitDTO, int $unitId): ?Unit
    {
        $unit = Unit::find($unitId);
        $unit->unit_name = $unitDTO->unitName;
        $unit->unit_code = $unitDTO->unitCode;
        $unit->save();

        return $unit;
    }

    public function delete_unit(int $unitId): ?Unit
    {
        $unit = Unit::find($unitId);
        $unit->deleted_at = date('Y-m-d H:i:s');
        $unit->save();

        return $unit;
    }
}
