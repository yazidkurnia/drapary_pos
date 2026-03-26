<?php

namespace App\Modules\ManageColors\Domain\Usecases;

use App\Models\Color;
use App\Modules\ManageColors\Application\DTOs\ColorDTO;
use App\Modules\ManageColors\Domain\Repositories\ManageColorRepositoryInterface;

class CreateManageColorUsecase
{
    public function __construct(
        private ManageColorRepositoryInterface $colorRepository
    ) {}
    public function store(ColorDTO $colorDTO): Color
    {
        return $this->colorRepository->add_new_color($colorDTO);
    }
}
