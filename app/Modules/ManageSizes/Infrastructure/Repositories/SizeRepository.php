<?php

namespace App\Modules\ManageSizes\Infrastructure\Repositories;

use App\Models\Size;
use App\Modules\ManageSizes\Domain\Repositories\ManageSizeRepositoryInterface;
use App\Modules\ManageSizes\Application\DTOs\SizeDTO;

class SizeRepository implements ManageSizeRepositoryInterface
{
    public function find_size_by_name(string $sizeName): ?Size
    {
        return Size::where('size_name', $sizeName)->first();
    }

    public function find_size_by_code(string $sizeCode): ?Size
    {
        return Size::where('size_code', $sizeCode)->first();
    }

    public function find_size_by_id(int $sizeId): ?Size
    {
        return Size::find($sizeId);
    }

    public function add_new_size(SizeDTO $sizeDTO): ?Size
    {
        return Size::create([
            'size_name' => $sizeDTO->sizeName,
            'size_code' => $sizeDTO->sizeCode,
        ]);
    }

    public function update_size(SizeDTO $sizeDTO, int $sizeId): ?Size
    {
        $size = Size::find($sizeId);
        $size->size_name = $sizeDTO->sizeName;
        $size->size_code = $sizeDTO->sizeCode;
        $size->save();

        return $size;
    }

    public function delete_size(int $sizeId): ?Size
    {
        $size = Size::find($sizeId);
        $size->deleted_at = date('Y-m-d H:i:s');
        $size->save();

        return $size;
    }
}
