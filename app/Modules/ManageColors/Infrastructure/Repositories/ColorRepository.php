<?php

namespace App\Modules\ManageColors\Infrastructure\Repositories;

use App\Models\Color;
use App\Modules\ManageColors\Domain\Repositories\ManageColorRepositoryInterface;
use App\Modules\ManageColors\Application\DTOs\ColorDTO;

class ColorRepository implements ManageColorRepositoryInterface {
    public function find_color_by_name(string $colorName): ?Color{
       return Color::where('color_name', $colorName)->first();
    }

    public function find_color_by_hexacode(string $colorHexa): ?Color{
        return Color::where('hexa_code', $colorHexa)->first();
    }

    public function find_color_by_id(int $colorId): ?Color{
        return Color::find($colorId);
    }

    public function add_new_color(ColorDTO $colorDTO): ?Color{
        $color = Color::create([
            'color_name' => $colorDTO->colorName,
            'hexa_code'  => $colorDTO->hexaCode,
            'is_active'  => $colorDTO->isActive,
        ]);

        return $color;
    }

    public function update_color(ColorDTO $colorDTO, int $mcid): ?Color{
        $mcData = Color::find($mcid);

        $mcData->color_name = $colorDTO->colorName;
        $mcData->hexa_code = $colorDTO->hexaCode;
        $mcData->is_active = $colorDTO->isActive;

        $mcData->save();


        return $mcData;
    }

    public function delete_color(int $mcid): ?Color{
        $mcData = Color::find($mcid);

        $mcData->deleted_at = date('Y-m-d H:i:s');
        $mcData->save();

        return $mcData;
    }
}