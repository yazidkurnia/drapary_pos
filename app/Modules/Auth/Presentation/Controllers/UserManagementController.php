<?php

namespace App\Modules\Auth\Presentation\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Auth\Application\DTOs\CreateUserDTO;
use App\Modules\Auth\Application\Services\AuthService;
use App\Modules\Auth\Presentation\Requests\CreateUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function index(): View
    {
        $users = $this->authService->getAllUsers();
        return view('pages.users.index', compact('users'));
    }

    public function create(): View
    {
        $roles = Role::all();
        return view('pages.users.create', compact('roles'));
    }

    public function store(CreateUserRequest $request): RedirectResponse
    {
        $dto = CreateUserDTO::fromRequest($request->validated());
        $this->authService->createUser($dto);
        return redirect()->route('users.index')->with('success', 'User berhasil dibuat.');
    }

    public function edit(User $user): View
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('name')->toArray();
        return view('pages.users.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(CreateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->only(['name', 'email', 'password']);
        $roles = $request->input('roles', []);
        $this->authService->updateUser($user, $data, $roles);
        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        $this->authService->deleteUser($user);
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
