<?php

namespace App\Modules\ManageCollars\Infrastructure\Repositories;

use App\Models\Collar;
use App\Modules\ManageCollars\Domain\Repositories\ManageCollarRepositoryInterface;
use App\Modules\ManageCollars\Application\DTOs\CollarDTO;

class CollarRepository implements ManageCollarRepositoryInterface
{
    public function find_collar_by_name(string $collarName): ?Collar
    {
        return Collar::where('collar_name', $collarName)->first();
    }

    public function find_collar_by_code(string $collarCode): ?Collar
    {
        return Collar::where('collar_code', $collarCode)->first();
    }

    public function find_collar_by_id(int $collarId): ?Collar
    {
        return Collar::find($collarId);
    }

    public function add_new_collar(CollarDTO $collarDTO): ?Collar
    {
        return Collar::create([
            'collar_name' => $collarDTO->collarName,
            'collar_code' => $collarDTO->collarCode,
        ]);
    }

    public function update_collar(CollarDTO $collarDTO, int $collarId): ?Collar
    {
        $collar = Collar::find($collarId);
        $collar->collar_name = $collarDTO->collarName;
        $collar->collar_code = $collarDTO->collarCode;
        $collar->save();

        return $collar;
    }

    public function delete_collar(int $collarId): ?Collar
    {
        $collar = Collar::find($collarId);
        $collar->deleted_at = date('Y-m-d H:i:s');
        $collar->save();

        return $collar;
    }
}
