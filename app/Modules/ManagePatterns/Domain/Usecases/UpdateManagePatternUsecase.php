<?php

namespace App\Modules\ManagePatterns\Domain\Usecases;

use App\Models\Pattern;
use App\Modules\ManagePatterns\Application\DTOs\PatternDTO;
use App\Modules\ManagePatterns\Domain\Repositories\ManagePatternRepositoryInterface;

class UpdateManagePatternUsecase
{
    public function __construct(private ManagePatternRepositoryInterface $patternRepository) {}

    public function update_usecase(PatternDTO $patternDTO, int $patternId): Pattern
    {
        return $this->patternRepository->update_pattern($patternDTO, $patternId);
    }
}
