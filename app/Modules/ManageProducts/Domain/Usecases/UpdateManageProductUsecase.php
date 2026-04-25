<?php

namespace App\Modules\ManageProducts\Domain\Usecases;

use App\Models\Product;
use App\Modules\ManageProducts\Application\DTOs\ProductDTO;
use App\Modules\ManageProducts\Domain\Repositories\ManageProductRepositoryInterface;

class UpdateManageProductUsecase
{
    public function __construct(private ManageProductRepositoryInterface $productRepository) {}

    public function update_usecase(ProductDTO $productDTO, int $productId): Product
    {
        return $this->productRepository->update_product($productDTO, $productId);
    }
}
