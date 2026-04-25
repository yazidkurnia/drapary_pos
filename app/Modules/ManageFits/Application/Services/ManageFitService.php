<?php

namespace App\Modules\ManageFits\Application\Services;

use App\Models\Fit;
use App\Modules\ManageFits\Application\DTOs\FitDTO;
use App\Modules\ManageFits\Domain\Repositories\ManageFitRepositoryInterface;
use App\Modules\ManageFits\Domain\Usecases\CreateManageFitUsecase;
use App\Modules\ManageFits\Domain\Usecases\UpdateManageFitUsecase;
use Illuminate\Support\Facades\Crypt;

class ManageFitService
{
    public function __construct(
        private CreateManageFitUsecase $createFitUsecase,
        private UpdateManageFitUsecase $updateFitUsecase,
        private ManageFitRepositoryInterface $fitRepository
    ) {}

    public function store(FitDTO $fitDTO): Fit
    {
        if ($this->fitRepository->find_fit_by_name($fitDTO->fitName)) {
            throw new \InvalidArgumentException('Nama tipe potongan telah digunakan!');
        }

        if ($this->fitRepository->find_fit_by_code($fitDTO->fitCode)) {
            throw new \InvalidArgumentException('Kode tipe potongan telah digunakan!');
        }

        return $this->createFitUsecase->store($fitDTO);
    }

    public function fetch_by_id(string $fitId): Fit
    {
        $id = (int) Crypt::decryptString($fitId);

        if ($id == 0) {
            throw new \InvalidArgumentException('Tipe potongan yang dipilih tidak valid!');
        }

        $fit = $this->fitRepository->find_fit_by_id($id);

        if (empty($fit)) {
            throw new \InvalidArgumentException('Data tipe potongan tidak ditemukan!');
        }

        $fit->mfid = Crypt::encryptString($fit->id);

        return $fit;
    }

    public function update_service(FitDTO $fitDTO, string $fitId): Fit
    {
        $id = (int) Crypt::decryptString($fitId);

        $fit = $this->fitRepository->find_fit_by_id($id);

        if (empty($fit)) {
            throw new \InvalidArgumentException('Data tipe potongan tidak ditemukan!');
        }

        return $this->updateFitUsecase->update_usecase($fitDTO, $id);
    }

    public function destroy_fit(string $fitId): Fit
    {
        $id = (int) Crypt::decryptString($fitId);

        $fit = $this->fitRepository->find_fit_by_id($id);

        if (empty($fit)) {
            throw new \InvalidArgumentException('Data tipe potongan tidak ditemukan!');
        }

        return $this->fitRepository->delete_fit($id);
    }
}
