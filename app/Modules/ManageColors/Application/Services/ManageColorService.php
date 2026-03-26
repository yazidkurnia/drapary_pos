<?php

namespace App\Modules\ManageColors\Application\Services;

use App\Models\Color;
use App\Modules\ManageColors\Application\DTOs\ColorDTO;
use App\Modules\ManageColors\Domain\Repositories\ManageColorRepositoryInterface;
use App\Modules\ManageColors\Domain\Usecases\CreateManageColorUsecase;
use App\Modules\ManageColors\Domain\Usecases\UpdateManageColorUsecase;
use Illuminate\Support\Facades\Crypt;

class ManageColorService
{
    public function __construct(
        private CreateManageColorUsecase $createColorUsecase,
        private UpdateManageColorUsecase $updateColorUsecase,
        private ManageColorRepositoryInterface $colorRepository
    ) {}

    public function store(ColorDTO $colorDTO): Color
    {
        if ($this->colorRepository->find_color_by_name($colorDTO->colorName)) {
            throw new \InvalidArgumentException('Nama telah digunakan!');
        }

        if ($this->colorRepository->find_color_by_hexacode($colorDTO->hexaCode)) {
            throw new \InvalidArgumentException('Warna telah terdaftar!');
        }

        return $this->createColorUsecase->store($colorDTO);
    }

    public function fetch_by_id(string $colorId): Color
    {
        $mcid = (int) Crypt::decryptString($colorId);

        if ($mcid == 0) {
            throw new \InvalidArgumentException('Warna yang dipilih tidak valid!');
        }

        $color = $this->colorRepository->find_color_by_id($mcid);

        if (empty($color)) {
            throw new \InvalidArgumentException('Data warna tidak ditemukan!');
        }

        $color->mcid = Crypt::encryptString($color->id);

        return $color;
    }

    /**
     * @param ColorDTO $colorDTO
     * @param string $colorId
     * return Color
     */
    public function update_service(ColorDTO $colorDTO, string $colorId): Color
    {
        $mcid = (int) Crypt::decryptString($colorId);
        // cek apakah warna tersedia
        $color = $this->colorRepository->find_color_by_id($mcid);

        if (empty($color)) {
            throw new \InvalidArgumentException('Data warna tidak ditemukan!');
        }
        
        return $this->updateColorUsecase->update_usecase($colorDTO, $mcid);
    }
    
    public function destroy_color(string $id){
        $mcid = (int) Crypt::decryptString($id);
        
        $color = $this->colorRepository->find_color_by_id($mcid);
        
        if (empty($color)) {
            throw new \InvalidArgumentException('Data warna tidak ditemukan!');
        }

        return $this->colorRepository->delete_color($mcid);
        
    }
}
