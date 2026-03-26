<?php

namespace App\Modules\Auth\Domain\UseCases;

use App\Models\User;
use App\Modules\Auth\Application\DTOs\CreateUserDTO;
use App\Modules\Auth\Domain\Repositories\AuthRepositoryInterface;

class CreateUserUseCase
{
    public function __construct(private AuthRepositoryInterface $authRepository) {}

    public function execute(CreateUserDTO $dto): User
    {
        $user = $this->authRepository->createUser($dto);

        if (!empty($dto->roles)) {
            $user->syncRoles($dto->roles);
        }

        return $user;
    }
}
