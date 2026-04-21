<?php

namespace App\Modules\ManageBrands\Application\Services;

use App\Models\Brand;
use App\Modules\ManageBrands\Application\DTOs\BrandDTO;
use App\Modules\ManageBrands\Domain\Repositories\ManageBrandRepositoryInterface;
use App\Modules\ManageBrands\Domain\Usecases\CreateManageBrandUsecase;
use App\Modules\ManageBrands\Domain\Usecases\UpdateManageBrandUsecase;
use Illuminate\Support\Facades\Crypt;

class ManageBrandService
{
    public function __construct(
        private CreateManageBrandUsecase $createBrandUsecase,
        private UpdateManageBrandUsecase $updateBrandUsecase,
        private ManageBrandRepositoryInterface $brandRepository
    ) {}

    public function store(BrandDTO $brandDTO): Brand
    {
        if ($this->brandRepository->find_brand_by_name($brandDTO->brandName)) {
            throw new \InvalidArgumentException('Nama brand telah digunakan!');
        }

        if ($this->brandRepository->find_brand_by_code($brandDTO->brandCode)) {
            throw new \InvalidArgumentException('Kode brand telah digunakan!');
        }

        return $this->createBrandUsecase->store($brandDTO);
    }

    public function fetch_by_id(string $brandId): Brand
    {
        $id = (int) Crypt::decryptString($brandId);

        if ($id == 0) {
            throw new \InvalidArgumentException('Brand yang dipilih tidak valid!');
        }

        $brand = $this->brandRepository->find_brand_by_id($id);

        if (empty($brand)) {
            throw new \InvalidArgumentException('Data brand tidak ditemukan!');
        }

        $brand->mbid = Crypt::encryptString($brand->id);

        return $brand;
    }

    public function update_service(BrandDTO $brandDTO, string $brandId): Brand
    {
        $id = (int) Crypt::decryptString($brandId);

        $brand = $this->brandRepository->find_brand_by_id($id);

        if (empty($brand)) {
            throw new \InvalidArgumentException('Data brand tidak ditemukan!');
        }

        return $this->updateBrandUsecase->update_usecase($brandDTO, $id);
    }

    public function destroy_brand(string $brandId): Brand
    {
        $id = (int) Crypt::decryptString($brandId);

        $brand = $this->brandRepository->find_brand_by_id($id);

        if (empty($brand)) {
            throw new \InvalidArgumentException('Data brand tidak ditemukan!');
        }

        return $this->brandRepository->delete_brand($id);
    }
}
