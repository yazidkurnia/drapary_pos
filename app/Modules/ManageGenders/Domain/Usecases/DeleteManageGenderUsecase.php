<?php

namespace App\Modules\ManageGenders\Domain\Usecases;

use App\Models\Gender;
use App\Modules\ManageGenders\Domain\Repositories\ManageGenderRepositoryInterface;

class DeleteManageGenderUsecase
{
    public function __construct(private ManageGenderRepositoryInterface $genderRepository) {}

    public function delete_gender(int $genderId): Gender
    {
        return $this->genderRepository->delete_gender($genderId);
    }
}
