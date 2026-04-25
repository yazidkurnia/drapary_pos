<?php

namespace App\Modules\ManagePatterns\Domain\Usecases;

use App\Models\Pattern;
use App\Modules\ManagePatterns\Application\DTOs\PatternDTO;
use App\Modules\ManagePatterns\Domain\Repositories\ManagePatternRepositoryInterface;

class CreateManagePatternUsecase
{
    public function __construct(private ManagePatternRepositoryInterface $patternRepository) {}

    public function store(PatternDTO $patternDTO): Pattern
    {
        return $this->patternRepository->add_new_pattern($patternDTO);
    }
}
