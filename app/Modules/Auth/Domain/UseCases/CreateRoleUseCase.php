<?php

namespace App\Modules\Auth\Domain\UseCases;

use App\Modules\Auth\Application\DTOs\RoleDTO;
use Spatie\Permission\Models\Role;

class CreateRoleUseCase
{
    public function execute(RoleDTO $dto): Role
    {
        $role = Role::create(['name' => $dto->name, 'guard_name' => 'web']);
        $role->syncPermissions($dto->permissions);
        return $role;
    }
}
