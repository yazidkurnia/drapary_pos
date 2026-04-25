<?php

namespace App\Modules\ManageSleeves\Domain\Repositories;

use App\Models\Sleeve;
use App\Modules\ManageSleeves\Application\DTOs\SleeveDTO;

interface ManageSleeveRepositoryInterface {
    public function find_sleeve_by_name(string $sleeveName): ?Sleeve;
    public function find_sleeve_by_code(string $sleeveCode): ?Sleeve;
    public function find_sleeve_by_id(int $sleeveId): ?Sleeve;
    public function add_new_sleeve(SleeveDTO $sleeveDTO): ?Sleeve;
    public function update_sleeve(SleeveDTO $sleeveDTO, int $sleeveId): ?Sleeve;
    public function delete_sleeve(int $sleeveId): ?Sleeve;
}
