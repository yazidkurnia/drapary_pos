<?php

namespace App\Modules\ManageProducts\Application\DTOs;

use Illuminate\Http\Request;

class ProductDTO
{
    public function __construct(
        public readonly int $brandId,
        public readonly string $productName,
        public readonly ?string $description,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            brandId: (int) $request->input('brand_id'),
            productName: $request->input('product_name'),
            description: $request->input('description') ?: null,
        );
    }
}
