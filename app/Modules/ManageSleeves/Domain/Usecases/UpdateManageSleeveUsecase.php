<?php

namespace App\Modules\ManageSleeves\Domain\Usecases;

use App\Models\Sleeve;
use App\Modules\ManageSleeves\Application\DTOs\SleeveDTO;
use App\Modules\ManageSleeves\Domain\Repositories\ManageSleeveRepositoryInterface;

class UpdateManageSleeveUsecase
{
    public function __construct(private ManageSleeveRepositoryInterface $sleeveRepository) {}

    public function update_usecase(SleeveDTO $sleeveDTO, int $sleeveId): Sleeve
    {
        return $this->sleeveRepository->update_sleeve($sleeveDTO, $sleeveId);
    }
}
