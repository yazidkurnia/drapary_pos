<?php

namespace App\Modules\ManageSleeves\Application\Services;

use App\Models\Sleeve;
use App\Modules\ManageSleeves\Application\DTOs\SleeveDTO;
use App\Modules\ManageSleeves\Domain\Repositories\ManageSleeveRepositoryInterface;
use App\Modules\ManageSleeves\Domain\Usecases\CreateManageSleeveUsecase;
use App\Modules\ManageSleeves\Domain\Usecases\UpdateManageSleeveUsecase;
use Illuminate\Support\Facades\Crypt;

class ManageSleeveService
{
    public function __construct(
        private CreateManageSleeveUsecase $createSleeveUsecase,
        private UpdateManageSleeveUsecase $updateSleeveUsecase,
        private ManageSleeveRepositoryInterface $sleeveRepository
    ) {}

    public function store(SleeveDTO $sleeveDTO): Sleeve
    {
        if ($this->sleeveRepository->find_sleeve_by_name($sleeveDTO->sleeveName)) {
            throw new \InvalidArgumentException('Nama tipe lengan telah digunakan!');
        }

        if ($this->sleeveRepository->find_sleeve_by_code($sleeveDTO->sleeveCode)) {
            throw new \InvalidArgumentException('Kode tipe lengan telah digunakan!');
        }

        return $this->createSleeveUsecase->store($sleeveDTO);
    }

    public function fetch_by_id(string $sleeveId): Sleeve
    {
        $id = (int) Crypt::decryptString($sleeveId);

        if ($id == 0) {
            throw new \InvalidArgumentException('Tipe lengan yang dipilih tidak valid!');
        }

        $sleeve = $this->sleeveRepository->find_sleeve_by_id($id);

        if (empty($sleeve)) {
            throw new \InvalidArgumentException('Data tipe lengan tidak ditemukan!');
        }

        $sleeve->mslid = Crypt::encryptString($sleeve->id);

        return $sleeve;
    }

    public function update_service(SleeveDTO $sleeveDTO, string $sleeveId): Sleeve
    {
        $id = (int) Crypt::decryptString($sleeveId);

        $sleeve = $this->sleeveRepository->find_sleeve_by_id($id);

        if (empty($sleeve)) {
            throw new \InvalidArgumentException('Data tipe lengan tidak ditemukan!');
        }

        return $this->updateSleeveUsecase->update_usecase($sleeveDTO, $id);
    }

    public function destroy_sleeve(string $sleeveId): Sleeve
    {
        $id = (int) Crypt::decryptString($sleeveId);

        $sleeve = $this->sleeveRepository->find_sleeve_by_id($id);

        if (empty($sleeve)) {
            throw new \InvalidArgumentException('Data tipe lengan tidak ditemukan!');
        }

        return $this->sleeveRepository->delete_sleeve($id);
    }
}
