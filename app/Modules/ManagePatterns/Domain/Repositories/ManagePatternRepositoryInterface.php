<?php

namespace App\Modules\ManagePatterns\Domain\Repositories;

use App\Models\Pattern;
use App\Modules\ManagePatterns\Application\DTOs\PatternDTO;

interface ManagePatternRepositoryInterface {
    public function find_pattern_by_name(string $patternName): ?Pattern;
    public function find_pattern_by_code(string $patternCode): ?Pattern;
    public function find_pattern_by_id(int $patternId): ?Pattern;
    public function add_new_pattern(PatternDTO $patternDTO): ?Pattern;
    public function update_pattern(PatternDTO $patternDTO, int $patternId): ?Pattern;
    public function delete_pattern(int $patternId): ?Pattern;
}
