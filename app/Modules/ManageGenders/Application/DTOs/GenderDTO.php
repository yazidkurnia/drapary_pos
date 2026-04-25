<?php

namespace App\Modules\ManageGenders\Application\DTOs;

use Illuminate\Http\Request;

class GenderDTO
{
    public function __construct(
        public readonly string $genderName,
        public readonly string $genderCode,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            genderName: $request->input('gender_name'),
            genderCode: $request->input('gender_code'),
        );
    }
}
