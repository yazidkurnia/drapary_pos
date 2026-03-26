<?php

namespace App\Modules\Auth\Infrastructure\Repositories;

use App\Models\User;
use App\Modules\Auth\Application\DTOs\CreateUserDTO;
use App\Modules\Auth\Domain\Repositories\AuthRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function createUser(CreateUserDTO $dto): User
    {
        return User::create([
            'name'     => $dto->name,
            'email'    => $dto->email,
            'password' => Hash::make($dto->password),
        ]);
    }

    public function getAllUsers(): Collection
    {
        return User::with('roles')->latest()->get();
    }

    public function findById(int $id): ?User
    {
        return User::with('roles')->find($id);
    }

    public function updateUser(User $user, array $data): User
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return $user->fresh('roles');
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
    }
}
