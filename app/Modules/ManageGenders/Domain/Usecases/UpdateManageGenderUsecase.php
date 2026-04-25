<?php

namespace App\Modules\ManageGenders\Domain\Usecases;

use App\Models\Gender;
use App\Modules\ManageGenders\Application\DTOs\GenderDTO;
use App\Modules\ManageGenders\Domain\Repositories\ManageGenderRepositoryInterface;

class UpdateManageGenderUsecase
{
    public function __construct(private ManageGenderRepositoryInterface $genderRepository) {}

    public function update_usecase(GenderDTO $genderDTO, int $genderId): Gender
    {
        return $this->genderRepository->update_gender($genderDTO, $genderId);
    }
}
