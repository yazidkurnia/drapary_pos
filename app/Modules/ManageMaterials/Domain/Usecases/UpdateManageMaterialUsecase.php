<?php

namespace App\Modules\ManageMaterials\Domain\Usecases;

use App\Models\Material;
use App\Modules\ManageMaterials\Application\DTOs\MaterialDTO;
use App\Modules\ManageMaterials\Domain\Repositories\ManageMaterialRepositoryInterface;

class UpdateManageMaterialUsecase
{
    public function __construct(
        private ManageMaterialRepositoryInterface $materialRepository
    ) {}

    public function update_usecase(MaterialDTO $materialDTO, int $materialId): Material
    {
        return $this->materialRepository->update_material($materialDTO, $materialId);
    }
}
