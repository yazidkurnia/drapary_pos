<?php

namespace App\Modules\ManageUnits\Application\Services;

use App\Models\Unit;
use App\Modules\ManageUnits\Application\DTOs\UnitDTO;
use App\Modules\ManageUnits\Domain\Repositories\ManageUnitRepositoryInterface;
use App\Modules\ManageUnits\Domain\Usecases\CreateManageUnitUsecase;
use App\Modules\ManageUnits\Domain\Usecases\UpdateManageUnitUsecase;
use Illuminate\Support\Facades\Crypt;

class ManageUnitService
{
    public function __construct(
        private CreateManageUnitUsecase $createUnitUsecase,
        private UpdateManageUnitUsecase $updateUnitUsecase,
        private ManageUnitRepositoryInterface $unitRepository
    ) {}

    public function store(UnitDTO $unitDTO): Unit
    {
        if ($this->unitRepository->find_unit_by_name($unitDTO->unitName)) {
            throw new \InvalidArgumentException('Nama satuan telah digunakan!');
        }

        if ($this->unitRepository->find_unit_by_code($unitDTO->unitCode)) {
            throw new \InvalidArgumentException('Kode satuan telah digunakan!');
        }

        return $this->createUnitUsecase->store($unitDTO);
    }

    public function fetch_by_id(string $unitId): Unit
    {
        $id = (int) Crypt::decryptString($unitId);

        if ($id == 0) {
            throw new \InvalidArgumentException('Satuan yang dipilih tidak valid!');
        }

        $unit = $this->unitRepository->find_unit_by_id($id);

        if (empty($unit)) {
            throw new \InvalidArgumentException('Data satuan tidak ditemukan!');
        }

        $unit->muid = Crypt::encryptString($unit->id);

        return $unit;
    }

    public function update_service(UnitDTO $unitDTO, string $unitId): Unit
    {
        $id = (int) Crypt::decryptString($unitId);

        $unit = $this->unitRepository->find_unit_by_id($id);

        if (empty($unit)) {
            throw new \InvalidArgumentException('Data satuan tidak ditemukan!');
        }

        return $this->updateUnitUsecase->update_usecase($unitDTO, $id);
    }

    public function destroy_unit(string $unitId): Unit
    {
        $id = (int) Crypt::decryptString($unitId);

        $unit = $this->unitRepository->find_unit_by_id($id);

        if (empty($unit)) {
            throw new \InvalidArgumentException('Data satuan tidak ditemukan!');
        }

        return $this->unitRepository->delete_unit($id);
    }
}
