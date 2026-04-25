<?php

namespace App\Modules\ManageMaterials\Application\DTOs;

use Illuminate\Http\Request;

class MaterialDTO
{
    public function __construct(
        public readonly string $materialName,
        public readonly string $materialCode,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            materialName: $request->input('material_name'),
            materialCode: $request->input('material_code'),
        );
    }
}
