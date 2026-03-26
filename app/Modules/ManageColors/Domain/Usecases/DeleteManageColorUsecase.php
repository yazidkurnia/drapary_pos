<?php

namespace App\Modules\ManageColors\Domain\Usecases;

use App\Models\Color;
use App\Modules\ManageColors\Application\DTOs\ColorDTO;
use App\Modules\ManageColors\Domain\Repositories\ManageColorRepositoryInterface;

class DeleteManageColorUsecase
{
    public function __construct(
        private ManageColorRepositoryInterface $colorRepository
    ) {}
    public function delete_color(ColorDTO $colorDTO, int $mcid): Color
    {
        return $this->colorRepository->delete_color($mcid);
    }
}
       