<?php

namespace App\Modules\ManageFits\Domain\Usecases;

use App\Models\Fit;
use App\Modules\ManageFits\Domain\Repositories\ManageFitRepositoryInterface;

class DeleteManageFitUsecase
{
    public function __construct(private ManageFitRepositoryInterface $fitRepository) {}

    public function delete_fit(int $fitId): Fit
    {
        return $this->fitRepository->delete_fit($fitId);
    }
}
