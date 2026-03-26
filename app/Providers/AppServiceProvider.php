<?php

namespace App\Providers;

use App\Modules\ManageColors\Domain\Repositories\ManageColorRepositoryInterface;
use App\Modules\ManageColors\Infrastructure\Repositories\ColorRepository;
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
