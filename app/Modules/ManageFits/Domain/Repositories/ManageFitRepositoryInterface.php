<?php

namespace App\Modules\ManageFits\Domain\Repositories;

use App\Models\Fit;
use App\Modules\ManageFits\Application\DTOs\FitDTO;

interface ManageFitRepositoryInterface {
    public function find_fit_by_name(string $fitName): ?Fit;
    public function find_fit_by_code(string $fitCode): ?Fit;
    public function find_fit_by_id(int $fitId): ?Fit;
    public function add_new_fit(FitDTO $fitDTO): ?Fit;
    public function update_fit(FitDTO $fitDTO, int $fitId): ?Fit;
    public function delete_fit(int $fitId): ?Fit;
}
