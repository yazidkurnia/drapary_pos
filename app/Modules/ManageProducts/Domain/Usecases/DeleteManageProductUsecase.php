<?php

namespace App\Modules\ManageProducts\Domain\Usecases;

use App\Models\Product;
use App\Modules\ManageProducts\Domain\Repositories\ManageProductRepositoryInterface;

class DeleteManageProductUsecase
{
    public function __construct(private ManageProductRepositoryInterface $productRepository) {}

    public function delete_product(int $productId): Product
    {
        return $this->productRepository->delete_product($productId);
    }
}
