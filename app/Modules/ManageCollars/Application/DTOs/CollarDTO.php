<?php

namespace App\Modules\ManageCollars\Application\DTOs;

use Illuminate\Http\Request;

class CollarDTO
{
    public function __construct(
        public readonly string $collarName,
        public readonly string $collarCode,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            collarName: $request->input('collar_name'),
            collarCode: $request->input('collar_code'),
        );
    }
}
