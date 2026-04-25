<?php

namespace App\Modules\ManageSleeves\Domain\Usecases;

use App\Models\Sleeve;
use App\Modules\ManageSleeves\Application\DTOs\SleeveDTO;
use App\Modules\ManageSleeves\Domain\Repositories\ManageSleeveRepositoryInterface;

class CreateManageSleeveUsecase
{
    public function __construct(private ManageSleeveRepositoryInterface $sleeveRepository) {}

    public function store(SleeveDTO $sleeveDTO): Sleeve
    {
        return $this->sleeveRepository->add_new_sleeve($sleeveDTO);
    }
}
