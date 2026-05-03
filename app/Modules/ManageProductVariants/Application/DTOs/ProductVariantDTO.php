<?php

namespace App\Modules\ManageProductVariants\Application\DTOs;

use Illuminate\Http\Request;

class ProductVariantDTO
{
    /**
     * @param array<array{size_id:int, stock:int}> $sizeStocks
     */
    public function __construct(
        public readonly int $productId,
        public readonly string $sku,
        public readonly ?int $colorId,
        public readonly ?int $materialId,
        public readonly ?int $fitId,
        public readonly ?int $sleeveId,
        public readonly ?int $collarId,
        public readonly ?int $patternId,
        public readonly ?int $genderId,
        public readonly ?int $unitId,
        public readonly float $price,
        public readonly array $sizeStocks,
    ) {}

    public static function fromRequest(Request $request): self
    {
        $nullable = fn($key) => $request->filled($key) ? (int) $request->input($key) : null;

        $sizeStocks = [];
        foreach ((array) $request->input('size_stocks', []) as $row) {
            if (!empty($row['size_id'])) {
                $sizeStocks[] = [
                    'size_id' => (int) $row['size_id'],
                    'stock'   => max(0, (int) ($row['stock'] ?? 0)),
                ];
            }
        }

        return new self(
            productId:  (int) $request->input('product_id'),
            sku:        $request->input('sku'),
            colorId:    $nullable('color_id'),
            materialId: $nullable('material_id'),
            fitId:      $nullable('fit_id'),
            sleeveId:   $nullable('sleeve_id'),
            collarId:   $nullable('collar_id'),
            patternId:  $nullable('pattern_id'),
            genderId:   $nullable('gender_id'),
            unitId:     $nullable('unit_id'),
            price:      (float) $request->input('price', 0),
            sizeStocks: $sizeStocks,
        );
    }
}
