<?php

namespace App\Modules\ManageGenders\Domain\Repositories;

use App\Models\Gender;
use App\Modules\ManageGenders\Application\DTOs\GenderDTO;

interface ManageGenderRepositoryInterface {
    public function find_gender_by_name(string $genderName): ?Gender;
    public function find_gender_by_code(string $genderCode): ?Gender;
    public function find_gender_by_id(int $genderId): ?Gender;
    public function add_new_gender(GenderDTO $genderDTO): ?Gender;
    public function update_gender(GenderDTO $genderDTO, int $genderId): ?Gender;
    public function delete_gender(int $genderId): ?Gender;
}
