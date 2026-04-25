<?php

namespace App\Modules\ManageCollars\Domain\Usecases;

use App\Models\Collar;
use App\Modules\ManageCollars\Domain\Repositories\ManageCollarRepositoryInterface;

class DeleteManageCollarUsecase
{
    public function __construct(private ManageCollarRepositoryInterface $collarRepository) {}

    public function delete_collar(int $collarId): Collar
    {
        return $this->collarRepository->delete_collar($collarId);
    }
}
