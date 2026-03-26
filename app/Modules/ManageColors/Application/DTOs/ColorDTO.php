<?php

namespace App\Modules\ManageColors\Application\DTOs;

use Illuminate\Http\Request;

class ColorDTO
{
    public function __construct(
        public readonly string $colorName,
        public readonly string $hexaCode,
        public readonly bool $isActive
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            colorName: $request->input('color_name'),
            hexaCode:  $request->input('hexa_code'),
            isActive:  $request->boolean('is_active', true),
        );
    }
}
