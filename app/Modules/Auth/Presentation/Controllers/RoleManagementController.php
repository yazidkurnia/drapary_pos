<?php

namespace App\Modules\Auth\Presentation\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Application\DTOs\RoleDTO;
use App\Modules\Auth\Domain\UseCases\CreateRoleUseCase;
use App\Modules\Auth\Domain\UseCases\DeleteRoleUseCase;
use App\Modules\Auth\Domain\UseCases\UpdateRoleUseCase;
use App\Modules\Auth\Presentation\Requests\RoleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleManagementController extends Controller
{
    public function __construct(
        private CreateRoleUseCase $createRoleUseCase,
        private UpdateRoleUseCase $updateRoleUseCase,
        private DeleteRoleUseCase $deleteRoleUseCase,
    ) {}

    public function index(): View
    {
        $roles = Role::with('permissions')->orderBy('name')->get();
        return view('pages.roles.index', compact('roles'));
    }

    public function create(): View
    {
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($p) {
            return explode(' ', $p->name, 2)[0]; // group by first word: view, manage, access
        });
        return view('pages.roles.create', compact('permissions'));
    }

    public function store(RoleRequest $request): RedirectResponse
    {
        $dto = RoleDTO::fromRequest($request);
        $this->createRoleUseCase->execute($dto);
        return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan.');
    }

    public function edit(Role $role): View
    {
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($p) {
            return explode(' ', $p->name, 2)[0];
        });
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('pages.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        $dto = RoleDTO::fromRequest($request);
        $this->updateRoleUseCase->execute($role, $dto);
        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        if ($role->users()->count() > 0) {
            return back()->with('error', 'Role tidak dapat dihapus karena masih digunakan oleh user.');
        }
        $this->deleteRoleUseCase->execute($role);
        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus.');
    }
}
