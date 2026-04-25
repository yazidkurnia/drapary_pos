<?php

namespace App\Modules\ManageMaterials\Domain\Repositories;

use App\Models\Material;
use App\Modules\ManageMaterials\Application\DTOs\MaterialDTO;

interface ManageMaterialRepositoryInterface {
    public function find_material_by_name(string $materialName): ?Material;

    public function find_material_by_code(string $materialCode): ?Material;

    public function find_material_by_id(int $materialId): ?Material;

    public function add_new_material(MaterialDTO $materialDTO): ?Material;

    public function update_material(MaterialDTO $materialDTO, int $materialId): ?Material;

    public function delete_material(int $materialId): ?Material;
}
