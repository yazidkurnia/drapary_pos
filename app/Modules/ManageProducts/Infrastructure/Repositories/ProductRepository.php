<?php

namespace App\Modules\ManageProducts\Infrastructure\Repositories;

use App\Models\Product;
use App\Modules\ManageProducts\Application\DTOs\ProductDTO;
use App\Modules\ManageProducts\Domain\Repositories\ManageProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ManageProductRepositoryInterface
{
    public function find_product_by_id(int $productId): ?Product
    {
        return Product::find($productId);
    }

    public function find_products_by_brand(int $brandId): Collection
    {
        return Product::where('brand_id', $brandId)->orderBy('product_name')->get();
    }

    public function add_new_product(ProductDTO $productDTO): ?Product
    {
        return Product::create([
            'brand_id'     => $productDTO->brandId,
            'product_name' => $productDTO->productName,
            'description'  => $productDTO->description,
        ]);
    }

    public function update_product(ProductDTO $productDTO, int $productId): ?Product
    {
        $product = Product::find($productId);
        $product->brand_id     = $productDTO->brandId;
        $product->product_name = $productDTO->productName;
        $product->description  = $productDTO->description;
        $product->save();

        return $product;
    }

    public function delete_product(int $productId): ?Product
    {
        $product = Product::find($productId);
        $product->deleted_at = date('Y-m-d H:i:s');
        $product->save();

        return $product;
    }
}
