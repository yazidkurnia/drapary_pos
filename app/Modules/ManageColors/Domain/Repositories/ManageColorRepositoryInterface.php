<?php

namespace App\Modules\ManageColors\Domain\Repositories;

use App\Models\Color;
use App\Modules\ManageColors\Application\DTOs\ColorDTO;

interface ManageColorRepositoryInterface {
    public function find_color_by_name(string $colorName): ?Color;

    public function find_color_by_hexacode(string $colorHexa): ?Color;

    public function find_color_by_id(int $colorId): ?Color;

    public function add_new_color(ColorDTO $colorDTO): ?Color;

    public function update_color(ColorDTO $colorDTO, int $colorId): ?Color;

    public function delete_color(int $colorId): ?Color;
}