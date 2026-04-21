<?php

namespace App\Providers;

use App\Modules\ManageColors\Domain\Repositories\ManageColorRepositoryInterface;
use App\Modules\ManageColors\Infrastructure\Repositories\ColorRepository;
use App\Modules\ManageUnits\Domain\Repositories\ManageUnitRepositoryInterface;
use App\Modules\ManageUnits\Infrastructure\Repositories\UnitRepository;
use App\Modules\ManageSizes\Domain\Repositories\ManageSizeRepositoryInterface;
use App\Modules\ManageSizes\Infrastructure\Repositories\SizeRepository;
use App\Modules\ManageBrands\Domain\Repositories\ManageBrandRepositoryInterface;
use App\Modules\ManageBrands\Infrastructure\Repositories\BrandRepository;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ManageColorRepositoryInterface::class, ColorRepository::class);
        $this->app->bind(ManageUnitRepositoryInterface::class, UnitRepository::class);
        $this->app->bind(ManageSizeRepositoryInterface::class, SizeRepository::class);
        $this->app->bind(ManageBrandRepositoryInterface::class, BrandRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (str_starts_with(config('app.url'), 'https') || request()->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            URL::forceScheme('https');
        }
    }
}
