<?php

namespace App\Modules\ManageSleeves\Domain\Usecases;

use App\Models\Sleeve;
use App\Modules\ManageSleeves\Domain\Repositories\ManageSleeveRepositoryInterface;

class DeleteManageSleeveUsecase
{
    public function __construct(private ManageSleeveRepositoryInterface $sleeveRepository) {}

    public function delete_sleeve(int $sleeveId): Sleeve
    {
        return $this->sleeveRepository->delete_sleeve($sleeveId);
    }
}
