<?php

namespace App\Modules\ManageMaterials\Domain\Usecases;

use App\Models\Material;
use App\Modules\ManageMaterials\Application\DTOs\MaterialDTO;
use App\Modules\ManageMaterials\Domain\Repositories\ManageMaterialRepositoryInterface;

class CreateManageMaterialUsecase
{
    public function __construct(
        private ManageMaterialRepositoryInterface $materialRepository
    ) {}

    public function store(MaterialDTO $materialDTO): Material
    {
        return $this->materialRepository->add_new_material($materialDTO);
    }
}
