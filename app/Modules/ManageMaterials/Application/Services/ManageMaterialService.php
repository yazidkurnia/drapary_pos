<?php

namespace App\Modules\ManageMaterials\Application\Services;

use App\Models\Material;
use App\Modules\ManageMaterials\Application\DTOs\MaterialDTO;
use App\Modules\ManageMaterials\Domain\Repositories\ManageMaterialRepositoryInterface;
use App\Modules\ManageMaterials\Domain\Usecases\CreateManageMaterialUsecase;
use App\Modules\ManageMaterials\Domain\Usecases\UpdateManageMaterialUsecase;
use Illuminate\Support\Facades\Crypt;

class ManageMaterialService
{
    public function __construct(
        private CreateManageMaterialUsecase $createMaterialUsecase,
        private UpdateManageMaterialUsecase $updateMaterialUsecase,
        private ManageMaterialRepositoryInterface $materialRepository
    ) {}

    public function store(MaterialDTO $materialDTO): Material
    {
        if ($this->materialRepository->find_material_by_name($materialDTO->materialName)) {
            throw new \InvalidArgumentException('Nama material telah digunakan!');
        }

        if ($this->materialRepository->find_material_by_code($materialDTO->materialCode)) {
            throw new \InvalidArgumentException('Kode material telah digunakan!');
        }

        return $this->createMaterialUsecase->store($materialDTO);
    }

    public function fetch_by_id(string $materialId): Material
    {
        $id = (int) Crypt::decryptString($materialId);

        if ($id == 0) {
            throw new \InvalidArgumentException('Material yang dipilih tidak valid!');
        }

        $material = $this->materialRepository->find_material_by_id($id);

        if (empty($material)) {
            throw new \InvalidArgumentException('Data material tidak ditemukan!');
        }

        $material->mmid = Crypt::encryptString($material->id);

        return $material;
    }

    public function update_service(MaterialDTO $materialDTO, string $materialId): Material
    {
        $id = (int) Crypt::decryptString($materialId);

        $material = $this->materialRepository->find_material_by_id($id);

        if (empty($material)) {
            throw new \InvalidArgumentException('Data material tidak ditemukan!');
        }

        return $this->updateMaterialUsecase->update_usecase($materialDTO, $id);
    }

    public function destroy_material(string $materialId): Material
    {
        $id = (int) Crypt::decryptString($materialId);

        $material = $this->materialRepository->find_material_by_id($id);

        if (empty($material)) {
            throw new \InvalidArgumentException('Data material tidak ditemukan!');
        }

        return $this->materialRepository->delete_material($id);
    }
}
