<?php

namespace App\Modules\ManageGenders\Infrastructure\Repositories;

use App\Models\Gender;
use App\Modules\ManageGenders\Domain\Repositories\ManageGenderRepositoryInterface;
use App\Modules\ManageGenders\Application\DTOs\GenderDTO;

class GenderRepository implements ManageGenderRepositoryInterface
{
    public function find_gender_by_name(string $genderName): ?Gender
    {
        return Gender::where('gender_name', $genderName)->first();
    }

    public function find_gender_by_code(string $genderCode): ?Gender
    {
        return Gender::where('gender_code', $genderCode)->first();
    }

    public function find_gender_by_id(int $genderId): ?Gender
    {
        return Gender::find($genderId);
    }

    public function add_new_gender(GenderDTO $genderDTO): ?Gender
    {
        return Gender::create([
            'gender_name' => $genderDTO->genderName,
            'gender_code' => $genderDTO->genderCode,
        ]);
    }

    public function update_gender(GenderDTO $genderDTO, int $genderId): ?Gender
    {
        $gender = Gender::find($genderId);
        $gender->gender_name = $genderDTO->genderName;
        $gender->gender_code = $genderDTO->genderCode;
        $gender->save();

        return $gender;
    }

    public function delete_gender(int $genderId): ?Gender
    {
        $gender = Gender::find($genderId);
        $gender->deleted_at = date('Y-m-d H:i:s');
        $gender->save();

        return $gender;
    }
}
