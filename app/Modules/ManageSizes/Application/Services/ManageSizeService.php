<?php

namespace App\Modules\ManageSizes\Application\Services;

use App\Models\Size;
use App\Modules\ManageSizes\Application\DTOs\SizeDTO;
use App\Modules\ManageSizes\Domain\Repositories\ManageSizeRepositoryInterface;
use App\Modules\ManageSizes\Domain\Usecases\CreateManageSizeUsecase;
use App\Modules\ManageSizes\Domain\Usecases\UpdateManageSizeUsecase;
use Illuminate\Support\Facades\Crypt;

class ManageSizeService
{
    public function __construct(
        private CreateManageSizeUsecase $createSizeUsecase,
        private UpdateManageSizeUsecase $updateSizeUsecase,
        private ManageSizeRepositoryInterface $sizeRepository
    ) {}

    public function store(SizeDTO $sizeDTO): Size
    {
        if ($this->sizeRepository->find_size_by_name($sizeDTO->sizeName)) {
            throw new \InvalidArgumentException('Nama ukuran telah digunakan!');
        }

        if ($this->sizeRepository->find_size_by_code($sizeDTO->sizeCode)) {
            throw new \InvalidArgumentException('Kode ukuran telah digunakan!');
        }

        return $this->createSizeUsecase->store($sizeDTO);
    }

    public function fetch_by_id(string $sizeId): Size
    {
        $id = (int) Crypt::decryptString($sizeId);

        if ($id == 0) {
            throw new \InvalidArgumentException('Ukuran yang dipilih tidak valid!');
        }

        $size = $this->sizeRepository->find_size_by_id($id);

        if (empty($size)) {
            throw new \InvalidArgumentException('Data ukuran tidak ditemukan!');
        }

        $size->msid = Crypt::encryptString($size->id);

        return $size;
    }

    public function update_service(SizeDTO $sizeDTO, string $sizeId): Size
    {
        $id = (int) Crypt::decryptString($sizeId);

        $size = $this->sizeRepository->find_size_by_id($id);

        if (empty($size)) {
            throw new \InvalidArgumentException('Data ukuran tidak ditemukan!');
        }

        return $this->updateSizeUsecase->update_usecase($sizeDTO, $id);
    }

    public function destroy_size(string $sizeId): Size
    {
        $id = (int) Crypt::decryptString($sizeId);

        $size = $this->sizeRepository->find_size_by_id($id);

        if (empty($size)) {
            throw new \InvalidArgumentException('Data ukuran tidak ditemukan!');
        }

        return $this->sizeRepository->delete_size($id);
    }
}
