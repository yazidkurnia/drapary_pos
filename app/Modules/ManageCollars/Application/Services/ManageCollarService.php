<?php

namespace App\Modules\ManageCollars\Application\Services;

use App\Models\Collar;
use App\Modules\ManageCollars\Application\DTOs\CollarDTO;
use App\Modules\ManageCollars\Domain\Repositories\ManageCollarRepositoryInterface;
use App\Modules\ManageCollars\Domain\Usecases\CreateManageCollarUsecase;
use App\Modules\ManageCollars\Domain\Usecases\UpdateManageCollarUsecase;
use Illuminate\Support\Facades\Crypt;

class ManageCollarService
{
    public function __construct(
        private CreateManageCollarUsecase $createCollarUsecase,
        private UpdateManageCollarUsecase $updateCollarUsecase,
        private ManageCollarRepositoryInterface $collarRepository
    ) {}

    public function store(CollarDTO $collarDTO): Collar
    {
        if ($this->collarRepository->find_collar_by_name($collarDTO->collarName)) {
            throw new \InvalidArgumentException('Nama tipe leher telah digunakan!');
        }

        if ($this->collarRepository->find_collar_by_code($collarDTO->collarCode)) {
            throw new \InvalidArgumentException('Kode tipe leher telah digunakan!');
        }

        return $this->createCollarUsecase->store($collarDTO);
    }

    public function fetch_by_id(string $collarId): Collar
    {
        $id = (int) Crypt::decryptString($collarId);

        if ($id == 0) {
            throw new \InvalidArgumentException('Tipe leher yang dipilih tidak valid!');
        }

        $collar = $this->collarRepository->find_collar_by_id($id);

        if (empty($collar)) {
            throw new \InvalidArgumentException('Data tipe leher tidak ditemukan!');
        }

        $collar->mclid = Crypt::encryptString($collar->id);

        return $collar;
    }

    public function update_service(CollarDTO $collarDTO, string $collarId): Collar
    {
        $id = (int) Crypt::decryptString($collarId);

        $collar = $this->collarRepository->find_collar_by_id($id);

        if (empty($collar)) {
            throw new \InvalidArgumentException('Data tipe leher tidak ditemukan!');
        }

        return $this->updateCollarUsecase->update_usecase($collarDTO, $id);
    }

    public function destroy_collar(string $collarId): Collar
    {
        $id = (int) Crypt::decryptString($collarId);

        $collar = $this->collarRepository->find_collar_by_id($id);

        if (empty($collar)) {
            throw new \InvalidArgumentException('Data tipe leher tidak ditemukan!');
        }

        return $this->collarRepository->delete_collar($id);
    }
}
