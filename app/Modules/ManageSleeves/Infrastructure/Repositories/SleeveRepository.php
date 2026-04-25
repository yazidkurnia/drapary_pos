<?php

namespace App\Modules\ManageSleeves\Infrastructure\Repositories;

use App\Models\Sleeve;
use App\Modules\ManageSleeves\Domain\Repositories\ManageSleeveRepositoryInterface;
use App\Modules\ManageSleeves\Application\DTOs\SleeveDTO;

class SleeveRepository implements ManageSleeveRepositoryInterface
{
    public function find_sleeve_by_name(string $sleeveName): ?Sleeve
    {
        return Sleeve::where('sleeve_name', $sleeveName)->first();
    }

    public function find_sleeve_by_code(string $sleeveCode): ?Sleeve
    {
        return Sleeve::where('sleeve_code', $sleeveCode)->first();
    }

    public function find_sleeve_by_id(int $sleeveId): ?Sleeve
    {
        return Sleeve::find($sleeveId);
    }

    public function add_new_sleeve(SleeveDTO $sleeveDTO): ?Sleeve
    {
        return Sleeve::create([
            'sleeve_name' => $sleeveDTO->sleeveName,
            'sleeve_code' => $sleeveDTO->sleeveCode,
        ]);
    }

    public function update_sleeve(SleeveDTO $sleeveDTO, int $sleeveId): ?Sleeve
    {
        $sleeve = Sleeve::find($sleeveId);
        $sleeve->sleeve_name = $sleeveDTO->sleeveName;
        $sleeve->sleeve_code = $sleeveDTO->sleeveCode;
        $sleeve->save();

        return $sleeve;
    }

    public function delete_sleeve(int $sleeveId): ?Sleeve
    {
        $sleeve = Sleeve::find($sleeveId);
        $sleeve->deleted_at = date('Y-m-d H:i:s');
        $sleeve->save();

        return $sleeve;
    }
}
