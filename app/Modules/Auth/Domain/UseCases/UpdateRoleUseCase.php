<?php

namespace App\Modules\Auth\Domain\UseCases;

use App\Modules\Auth\Application\DTOs\RoleDTO;
use Spatie\Permission\Models\Role;

class UpdateRoleUseCase
{
    public function execute(Role $role, RoleDTO $dto): Role
    {
        $role->update(['name' => $dto->name]);
        $role->syncPermissions($dto->permissions);
        return $role->fresh();
    }
}
