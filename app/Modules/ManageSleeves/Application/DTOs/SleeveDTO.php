<?php

namespace App\Modules\ManageSleeves\Application\DTOs;

use Illuminate\Http\Request;

class SleeveDTO
{
    public function __construct(
        public readonly string $sleeveName,
        public readonly string $sleeveCode,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            sleeveName: $request->input('sleeve_name'),
            sleeveCode: $request->input('sleeve_code'),
        );
    }
}
