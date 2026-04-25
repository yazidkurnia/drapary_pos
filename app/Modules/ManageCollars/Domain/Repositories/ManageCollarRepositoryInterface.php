<?php

namespace App\Modules\ManageCollars\Domain\Repositories;

use App\Models\Collar;
use App\Modules\ManageCollars\Application\DTOs\CollarDTO;

interface ManageCollarRepositoryInterface {
    public function find_collar_by_name(string $collarName): ?Collar;
    public function find_collar_by_code(string $collarCode): ?Collar;
    public function find_collar_by_id(int $collarId): ?Collar;
    public function add_new_collar(CollarDTO $collarDTO): ?Collar;
    public function update_collar(CollarDTO $collarDTO, int $collarId): ?Collar;
    public function delete_collar(int $collarId): ?Collar;
}
