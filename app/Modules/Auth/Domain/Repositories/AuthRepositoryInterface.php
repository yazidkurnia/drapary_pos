<?php

namespace App\Modules\Auth\Domain\Repositories;

use App\Models\User;
use App\Modules\Auth\Application\DTOs\CreateUserDTO;

interface AuthRepositoryInterface
{
    public function findByEmail(string $email): ?User;

    public function createUser(CreateUserDTO $dto): User;

    public function getAllUsers(): \Illuminate\Database\Eloquent\Collection;

    public function findById(int $id): ?User;

    public function updateUser(User $user, array $data): User;

    public function deleteUser(User $user): void;
}
