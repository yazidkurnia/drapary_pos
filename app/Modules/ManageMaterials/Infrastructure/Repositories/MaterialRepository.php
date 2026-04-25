<?php

namespace App\Modules\ManageMaterials\Infrastructure\Repositories;

use App\Models\Material;
use App\Modules\ManageMaterials\Domain\Repositories\ManageMaterialRepositoryInterface;
use App\Modules\ManageMaterials\Application\DTOs\MaterialDTO;

class MaterialRepository implements ManageMaterialRepositoryInterface
{
    public function find_material_by_name(string $materialName): ?Material
    {
        return Material::where('material_name', $materialName)->first();
    }

    public function find_material_by_code(string $materialCode): ?Material
    {
        return Material::where('material_code', $materialCode)->first();
    }

    public function find_material_by_id(int $materialId): ?Material
    {
        return Material::find($materialId);
    }

    public function add_new_material(MaterialDTO $materialDTO): ?Material
    {
        return Material::create([
            'material_name' => $materialDTO->materialName,
            'material_code' => $materialDTO->materialCode,
        ]);
    }

    public function update_material(MaterialDTO $materialDTO, int $materialId): ?Material
    {
        $material = Material::find($materialId);
        $material->material_name = $materialDTO->materialName;
        $material->material_code = $materialDTO->materialCode;
        $material->save();

        return $material;
    }

    public function delete_material(int $materialId): ?Material
    {
        $material = Material::find($materialId);
        $material->deleted_at = date('Y-m-d H:i:s');
        $material->save();

        return $material;
    }
}
