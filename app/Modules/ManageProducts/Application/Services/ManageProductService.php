<?php

namespace App\Modules\ManageProducts\Application\Services;

use App\Models\Product;
use App\Modules\ManageProducts\Application\DTOs\ProductDTO;
use App\Modules\ManageProducts\Domain\Repositories\ManageProductRepositoryInterface;
use App\Modules\ManageProducts\Domain\Usecases\CreateManageProductUsecase;
use App\Modules\ManageProducts\Domain\Usecases\UpdateManageProductUsecase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Crypt;

class ManageProductService
{
    public function __construct(
        private CreateManageProductUsecase $createProductUsecase,
        private UpdateManageProductUsecase $updateProductUsecase,
        private ManageProductRepositoryInterface $productRepository
    ) {}

    public function store(ProductDTO $productDTO): Product
    {
        return $this->createProductUsecase->store($productDTO);
    }

    public function fetch_by_id(string $productId): Product
    {
        $id = (int) Crypt::decryptString($productId);

        if ($id == 0) {
            throw new \InvalidArgumentException('Produk yang dipilih tidak valid!');
        }

        $product = $this->productRepository->find_product_by_id($id);

        if (empty($product)) {
            throw new \InvalidArgumentException('Data produk tidak ditemukan!');
        }

        $product->mprid = Crypt::encryptString($product->id);

        return $product;
    }

    public function fetch_products_by_brand(int $brandId): Collection
    {
        return $this->productRepository->find_products_by_brand($brandId);
    }

    public function update_service(ProductDTO $productDTO, string $productId): Product
    {
        $id = (int) Crypt::decryptString($productId);

        $product = $this->productRepository->find_product_by_id($id);

        if (empty($product)) {
            throw new \InvalidArgumentException('Data produk tidak ditemukan!');
        }

        return $this->updateProductUsecase->update_usecase($productDTO, $id);
    }

    public function destroy_product(string $productId): Product
    {
        $id = (int) Crypt::decryptString($productId);

        $product = $this->productRepository->find_product_by_id($id);

        if (empty($product)) {
            throw new \InvalidArgumentException('Data produk tidak ditemukan!');
        }

        return $this->productRepository->delete_product($id);
    }
}
