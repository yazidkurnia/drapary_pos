<?php

namespace App\Modules\ManageCollars\Domain\Usecases;

use App\Models\Collar;
use App\Modules\ManageCollars\Application\DTOs\CollarDTO;
use App\Modules\ManageCollars\Domain\Repositories\ManageCollarRepositoryInterface;

class UpdateManageCollarUsecase
{
    public function __construct(private ManageCollarRepositoryInterface $collarRepository) {}

    public function update_usecase(CollarDTO $collarDTO, int $collarId): Collar
    {
        return $this->collarRepository->update_collar($collarDTO, $collarId);
    }
}
