<?php

namespace App\Modules\ManagePatterns\Domain\Usecases;

use App\Models\Pattern;
use App\Modules\ManagePatterns\Domain\Repositories\ManagePatternRepositoryInterface;

class DeleteManagePatternUsecase
{
    public function __construct(private ManagePatternRepositoryInterface $patternRepository) {}

    public function delete_pattern(int $patternId): Pattern
    {
        return $this->patternRepository->delete_pattern($patternId);
    }
}
