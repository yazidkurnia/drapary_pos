<?php

namespace App\Modules\ManageUnits\Application\DTOs;

use Illuminate\Http\Request;

class UnitDTO
{
    public function __construct(
        public readonly string $unitName,
        public readonly string $unitCode,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            unitName: $request->input('unit_name'),
            unitCode: $request->input('unit_code'),
        );
    }
}
