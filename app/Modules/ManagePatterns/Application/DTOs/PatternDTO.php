<?php

namespace App\Modules\ManagePatterns\Application\DTOs;

use Illuminate\Http\Request;

class PatternDTO
{
    public function __construct(
        public readonly string $patternName,
        public readonly string $patternCode,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            patternName: $request->input('pattern_name'),
            patternCode: $request->input('pattern_code'),
        );
    }
}
