<?php

namespace App\Modules\ManageGenders\Application\Services;

use App\Models\Gender;
use App\Modules\ManageGenders\Application\DTOs\GenderDTO;
use App\Modules\ManageGenders\Domain\Repositories\ManageGenderRepositoryInterface;
use App\Modules\ManageGenders\Domain\Usecases\CreateManageGenderUsecase;
use App\Modules\ManageGenders\Domain\Usecases\UpdateManageGenderUsecase;
use Illuminate\Support\Facades\Crypt;

class ManageGenderService
{
    public function __construct(
        private CreateManageGenderUsecase $createGenderUsecase,
        private UpdateManageGenderUsecase $updateGenderUsecase,
        private ManageGenderRepositoryInterface $genderRepository
    ) {}

    public function store(GenderDTO $genderDTO): Gender
    {
        if ($this->genderRepository->find_gender_by_name($genderDTO->genderName)) {
            throw new \InvalidArgumentException('Nama jenis kelamin telah digunakan!');
        }

        if ($this->genderRepository->find_gender_by_code($genderDTO->genderCode)) {
            throw new \InvalidArgumentException('Kode jenis kelamin telah digunakan!');
        }

        return $this->createGenderUsecase->store($genderDTO);
    }

    public function fetch_by_id(string $genderId): Gender
    {
        $id = (int) Crypt::decryptString($genderId);

        if ($id == 0) {
            throw new \InvalidArgumentException('Jenis kelamin yang dipilih tidak valid!');
        }

        $gender = $this->genderRepository->find_gender_by_id($id);

        if (empty($gender)) {
            throw new \InvalidArgumentException('Data jenis kelamin tidak ditemukan!');
        }

        $gender->mgid = Crypt::encryptString($gender->id);

        return $gender;
    }

    public function update_service(GenderDTO $genderDTO, string $genderId): Gender
    {
        $id = (int) Crypt::decryptString($genderId);

        $gender = $this->genderRepository->find_gender_by_id($id);

        if (empty($gender)) {
            throw new \InvalidArgumentException('Data jenis kelamin tidak ditemukan!');
        }

        return $this->updateGenderUsecase->update_usecase($genderDTO, $id);
    }

    public function destroy_gender(string $genderId): Gender
    {
        $id = (int) Crypt::decryptString($genderId);

        $gender = $this->genderRepository->find_gender_by_id($id);

        if (empty($gender)) {
            throw new \InvalidArgumentException('Data jenis kelamin tidak ditemukan!');
        }

        return $this->genderRepository->delete_gender($id);
    }
}
