<?php

namespace App\Modules\ManageMaterials\Domain\Usecases;

use App\Models\Material;
use App\Modules\ManageMaterials\Domain\Repositories\ManageMaterialRepositoryInterface;

class DeleteManageMaterialUsecase
{
    public function __construct(
        private ManageMaterialRepositoryInterface $materialRepository
    ) {}

    public function delete_material(int $materialId): Material
    {
        return $this->materialRepository->delete_material($materialId);
    }
}
