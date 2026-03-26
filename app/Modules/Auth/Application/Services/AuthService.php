<?php

namespace App\Modules\Auth\Application\Services;

use App\Models\User;
use App\Modules\Auth\Application\DTOs\CreateUserDTO;
use App\Modules\Auth\Application\DTOs\LoginDTO;
use App\Modules\Auth\Domain\Repositories\AuthRepositoryInterface;
use App\Modules\Auth\Domain\UseCases\CreateUserUseCase;
use App\Modules\Auth\Domain\UseCases\LoginUseCase;
use App\Modules\Auth\Domain\UseCases\LogoutUseCase;
use Illuminate\Http\Request;

class AuthService
{
    public function __construct(
        private AuthRepositoryInterface $authRepository,
        private LoginUseCase $loginUseCase,
        private LogoutUseCase $logoutUseCase,
        private CreateUserUseCase $createUserUseCase,
    ) {}

    public function login(LoginDTO $dto, string $ip): void
    {
        $this->loginUseCase->execute($dto, $ip);
    }

    public function logout(Request $request): void
    {
        $this->logoutUseCase->execute($request);
    }

    public function createUser(CreateUserDTO $dto): User
    {
        return $this->createUserUseCase->execute($dto);
    }

    public function getAllUsers(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->authRepository->getAllUsers();
    }

    public function findById(int $id): ?User
    {
        return $this->authRepository->findById($id);
    }

    public function updateUser(User $user, array $data, array $roles): User
    {
        $user = $this->authRepository->updateUser($user, $data);
        $user->syncRoles($roles);
        return $user;
    }

    public function deleteUser(User $user): void
    {
        $this->authRepository->deleteUser($user);
    }
}
