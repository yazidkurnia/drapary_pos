<?php

namespace App\Modules\ManageFits\Application\DTOs;

use Illuminate\Http\Request;

class FitDTO
{
    public function __construct(
        public readonly string $fitName,
        public readonly string $fitCode,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            fitName: $request->input('fit_name'),
            fitCode: $request->input('fit_code'),
        );
    }
}
