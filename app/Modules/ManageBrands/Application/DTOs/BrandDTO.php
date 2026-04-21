<?php

namespace App\Modules\ManageBrands\Application\DTOs;

use Illuminate\Http\Request;

class BrandDTO
{
    public function __construct(
        public readonly string $brandName,
        public readonly string $brandCode,
        public readonly ?string $description,
        public readonly bool $isActive,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            brandName:   $request->input('brand_name'),
            brandCode:   $request->input('brand_code'),
            description: $request->input('description'),
            isActive:    $request->boolean('is_active', true),
        );
    }
}
