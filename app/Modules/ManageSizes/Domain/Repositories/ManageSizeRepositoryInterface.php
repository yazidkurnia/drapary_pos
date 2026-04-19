<?php

namespace App\Modules\ManageSizes\Domain\Repositories;

use App\Models\Size;
use App\Modules\ManageSizes\Application\DTOs\SizeDTO;

interface ManageSizeRepositoryInterface {
    public function find_size_by_name(string $sizeName): ?Size;

    public function find_size_by_code(string $sizeCode): ?Size;

    public function find_size_by_id(int $sizeId): ?Size;

    public function add_new_size(SizeDTO $sizeDTO): ?Size;

    public function update_size(SizeDTO $sizeDTO, int $sizeId): ?Size;

    public function delete_size(int $sizeId): ?Size;
}
