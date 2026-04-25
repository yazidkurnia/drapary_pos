<?php

namespace App\Modules\ManageGenders\Domain\Usecases;

use App\Models\Gender;
use App\Modules\ManageGenders\Application\DTOs\GenderDTO;
use App\Modules\ManageGenders\Domain\Repositories\ManageGenderRepositoryInterface;

class CreateManageGenderUsecase
{
    public function __construct(private ManageGenderRepositoryInterface $genderRepository) {}

    public function store(GenderDTO $genderDTO): Gender
    {
        return $this->genderRepository->add_new_gender($genderDTO);
    }
}
