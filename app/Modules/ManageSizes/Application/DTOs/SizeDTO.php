<?php

namespace App\Modules\ManageSizes\Application\DTOs;

use Illuminate\Http\Request;

class SizeDTO
{
    public function __construct(
        public readonly string $sizeName,
        public readonly string $sizeCode,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            sizeName: $request->input('size_name'),
            sizeCode: $request->input('size_code'),
        );
    }
}
