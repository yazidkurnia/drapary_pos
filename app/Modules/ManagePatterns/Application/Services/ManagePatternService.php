<?php

namespace App\Modules\ManagePatterns\Application\Services;

use App\Models\Pattern;
use App\Modules\ManagePatterns\Application\DTOs\PatternDTO;
use App\Modules\ManagePatterns\Domain\Repositories\ManagePatternRepositoryInterface;
use App\Modules\ManagePatterns\Domain\Usecases\CreateManagePatternUsecase;
use App\Modules\ManagePatterns\Domain\Usecases\UpdateManagePatternUsecase;
use Illuminate\Support\Facades\Crypt;

class ManagePatternService
{
    public function __construct(
        private CreateManagePatternUsecase $createPatternUsecase,
        private UpdateManagePatternUsecase $updatePatternUsecase,
        private ManagePatternRepositoryInterface $patternRepository
    ) {}

    public function store(PatternDTO $patternDTO): Pattern
    {
        if ($this->patternRepository->find_pattern_by_name($patternDTO->patternName)) {
            throw new \InvalidArgumentException('Nama motif/pola telah digunakan!');
        }

        if ($this->patternRepository->find_pattern_by_code($patternDTO->patternCode)) {
            throw new \InvalidArgumentException('Kode motif/pola telah digunakan!');
        }

        return $this->createPatternUsecase->store($patternDTO);
    }

    public function fetch_by_id(string $patternId): Pattern
    {
        $id = (int) Crypt::decryptString($patternId);

        if ($id == 0) {
            throw new \InvalidArgumentException('Motif/pola yang dipilih tidak valid!');
        }

        $pattern = $this->patternRepository->find_pattern_by_id($id);

        if (empty($pattern)) {
            throw new \InvalidArgumentException('Data motif/pola tidak ditemukan!');
        }

        $pattern->mpid = Crypt::encryptString($pattern->id);

        return $pattern;
    }

    public function update_service(PatternDTO $patternDTO, string $patternId): Pattern
    {
        $id = (int) Crypt::decryptString($patternId);

        $pattern = $this->patternRepository->find_pattern_by_id($id);

        if (empty($pattern)) {
            throw new \InvalidArgumentException('Data motif/pola tidak ditemukan!');
        }

        return $this->updatePatternUsecase->update_usecase($patternDTO, $id);
    }

    public function destroy_pattern(string $patternId): Pattern
    {
        $id = (int) Crypt::decryptString($patternId);

        $pattern = $this->patternRepository->find_pattern_by_id($id);

        if (empty($pattern)) {
            throw new \InvalidArgumentException('Data motif/pola tidak ditemukan!');
        }

        return $this->patternRepository->delete_pattern($id);
    }
}
