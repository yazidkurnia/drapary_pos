<?php

namespace App\Modules\ManageFits\Domain\Usecases;

use App\Models\Fit;
use App\Modules\ManageFits\Application\DTOs\FitDTO;
use App\Modules\ManageFits\Domain\Repositories\ManageFitRepositoryInterface;

class CreateManageFitUsecase
{
    public function __construct(private ManageFitRepositoryInterface $fitRepository) {}

    public function store(FitDTO $fitDTO): Fit
    {
        return $this->fitRepository->add_new_fit($fitDTO);
    }
}
