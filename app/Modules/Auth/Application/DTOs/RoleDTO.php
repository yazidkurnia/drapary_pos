<?php

namespace App\Modules\Auth\Application\DTOs;

use Illuminate\Http\Request;

class RoleDTO
{
    public function __construct(
        public readonly string $name,
        public readonly array $permissions,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->input('name'),
            permissions: $request->input('permissions', []),
        );
    }
}
