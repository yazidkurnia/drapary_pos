<?php

namespace App\Modules\ManageColors\Domain\Usecases;

use App\Models\Color;
use App\Modules\ManageColors\Application\DTOs\ColorDTO;
use App\Modules\ManageColors\Domain\Repositories\ManageColorRepositoryInterface;

class UpdateManageColorUsecase
{
    public function __construct(
        private ManageColorRepositoryInterface $colorRepository
    ) {}
    public function update_usecase(ColorDTO $colorDTO, int $mcid): Color
    {
        return $this->colorRepository->update_color($colorDTO, $mcid);
    }
}
       