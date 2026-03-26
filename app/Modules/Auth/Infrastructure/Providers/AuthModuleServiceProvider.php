<?php

namespace App\Modules\Auth\Infrastructure\Providers;

use App\Modules\Auth\Application\Services\AuthService;
use App\Modules\Auth\Domain\Repositories\AuthRepositoryInterface;
use App\Modules\Auth\Domain\UseCases\CreateRoleUseCase;
use App\Modules\Auth\Domain\UseCases\CreateUserUseCase;
use App\Modules\Auth\Domain\UseCases\DeleteRoleUseCase;
use App\Modules\Auth\Domain\UseCases\LoginUseCase;
use App\Modules\Auth\Domain\UseCases\LogoutUseCase;
use App\Modules\Auth\Domain\UseCases\UpdateRoleUseCase;
use App\Modules\Auth\Infrastructure\Repositories\AuthRepository;
use App\Modules\Auth\Presentation\Controllers\RoleManagementController;
use Illuminate\Support\ServiceProvider;

class AuthModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);

        $this->app->bind(LoginUseCase::class, function ($app) {
            return new LoginUseCase($app->make(AuthRepositoryInterface::class));
        });

        $this->app->bind(CreateUserUseCase::class, function ($app) {
            return new CreateUserUseCase($app->make(AuthRepositoryInterface::class));
        });

        $this->app->bind(AuthService::class, function ($app) {
            return new AuthService(
                $app->make(AuthRepositoryInterface::class),
                $app->make(LoginUseCase::class),
                $app->make(LogoutUseCase::class),
                $app->make(CreateUserUseCase::class),
            );
        });

        $this->app->bind(RoleManagementController::class, function ($app) {
            return new RoleManagementController(
                $app->make(CreateRoleUseCase::class),
                $app->make(UpdateRoleUseCase::class),
                $app->make(DeleteRoleUseCase::class),
            );
        });
    }

    public function boot(): void {}
}
