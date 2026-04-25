<?php

namespace App\Modules\ManagePatterns\Infrastructure\Repositories;

use App\Models\Pattern;
use App\Modules\ManagePatterns\Domain\Repositories\ManagePatternRepositoryInterface;
use App\Modules\ManagePatterns\Application\DTOs\PatternDTO;

class PatternRepository implements ManagePatternRepositoryInterface
{
    public function find_pattern_by_name(string $patternName): ?Pattern
    {
        return Pattern::where('pattern_name', $patternName)->first();
    }

    public function find_pattern_by_code(string $patternCode): ?Pattern
    {
        return Pattern::where('pattern_code', $patternCode)->first();
    }

    public function find_pattern_by_id(int $patternId): ?Pattern
    {
        return Pattern::find($patternId);
    }

    public function add_new_pattern(PatternDTO $patternDTO): ?Pattern
    {
        return Pattern::create([
            'pattern_name' => $patternDTO->patternName,
            'pattern_code' => $patternDTO->patternCode,
        ]);
    }

    public function update_pattern(PatternDTO $patternDTO, int $patternId): ?Pattern
    {
        $pattern = Pattern::find($patternId);
        $pattern->pattern_name = $patternDTO->patternName;
        $pattern->pattern_code = $patternDTO->patternCode;
        $pattern->save();

        return $pattern;
    }

    public function delete_pattern(int $patternId): ?Pattern
    {
        $pattern = Pattern::find($patternId);
        $pattern->deleted_at = date('Y-m-d H:i:s');
        $pattern->save();

        return $pattern;
    }
}
