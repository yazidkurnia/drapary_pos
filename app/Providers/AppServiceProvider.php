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
use App\Modules\ManageMaterials\Domain\Repositories\ManageMaterialRepositoryInterface;
use App\Modules\ManageMaterials\Infrastructure\Repositories\MaterialRepository;
use App\Modules\ManageFits\Domain\Repositories\ManageFitRepositoryInterface;
use App\Modules\ManageFits\Infrastructure\Repositories\FitRepository;
use App\Modules\ManageSleeves\Domain\Repositories\ManageSleeveRepositoryInterface;
use App\Modules\ManageSleeves\Infrastructure\Repositories\SleeveRepository;
use App\Modules\ManageCollars\Domain\Repositories\ManageCollarRepositoryInterface;
use App\Modules\ManageCollars\Infrastructure\Repositories\CollarRepository;
use App\Modules\ManagePatterns\Domain\Repositories\ManagePatternRepositoryInterface;
use App\Modules\ManagePatterns\Infrastructure\Repositories\PatternRepository;
use App\Modules\ManageGenders\Domain\Repositories\ManageGenderRepositoryInterface;
use App\Modules\ManageGenders\Infrastructure\Repositories\GenderRepository;
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
        $this->app->bind(ManageMaterialRepositoryInterface::class, MaterialRepository::class);
        $this->app->bind(ManageFitRepositoryInterface::class, FitRepository::class);
        $this->app->bind(ManageSleeveRepositoryInterface::class, SleeveRepository::class);
        $this->app->bind(ManageCollarRepositoryInterface::class, CollarRepository::class);
        $this->app->bind(ManagePatternRepositoryInterface::class, PatternRepository::class);
        $this->app->bind(ManageGenderRepositoryInterface::class, GenderRepository::class);
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
