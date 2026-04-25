<?php

namespace App\Modules\ManageCollars\Domain\Usecases;

use App\Models\Collar;
use App\Modules\ManageCollars\Application\DTOs\CollarDTO;
use App\Modules\ManageCollars\Domain\Repositories\ManageCollarRepositoryInterface;

class CreateManageCollarUsecase
{
    public function __construct(private ManageCollarRepositoryInterface $collarRepository) {}

    public function store(CollarDTO $collarDTO): Collar
    {
        return $this->collarRepository->add_new_collar($collarDTO);
    }
}
