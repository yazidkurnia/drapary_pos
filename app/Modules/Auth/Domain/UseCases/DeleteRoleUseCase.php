<?php

namespace App\Modules\Auth\Domain\UseCases;

use Spatie\Permission\Models\Role;

class DeleteRoleUseCase
{
    public function execute(Role $role): void
    {
        $role->delete();
    }
}
