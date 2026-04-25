<?php

namespace App\Modules\ManageFits\Domain\Usecases;

use App\Models\Fit;
use App\Modules\ManageFits\Application\DTOs\FitDTO;
use App\Modules\ManageFits\Domain\Repositories\ManageFitRepositoryInterface;

class UpdateManageFitUsecase
{
    public function __construct(private ManageFitRepositoryInterface $fitRepository) {}

    public function update_usecase(FitDTO $fitDTO, int $fitId): Fit
    {
        return $this->fitRepository->update_fit($fitDTO, $fitId);
    }
}
