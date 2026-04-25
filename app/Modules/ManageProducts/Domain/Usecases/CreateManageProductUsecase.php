<?php

namespace App\Modules\ManageProducts\Domain\Usecases;

use App\Models\Product;
use App\Modules\ManageProducts\Application\DTOs\ProductDTO;
use App\Modules\ManageProducts\Domain\Repositories\ManageProductRepositoryInterface;

class CreateManageProductUsecase
{
    public function __construct(private ManageProductRepositoryInterface $productRepository) {}

    public function store(ProductDTO $productDTO): Product
    {
        return $this->productRepository->add_new_product($productDTO);
    }
}
