<?php

namespace ZPlus\ViPOS\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Webkul\Core\Http\Middleware\PreventRequestsDuringMaintenance;

class ViPOSServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerConfig();
    }

    /**
     * Bootstrap services.
     */
    public function boot(Router $router): void
    {
        Route::middleware(['web', 'admin', PreventRequestsDuringMaintenance::class])->group(__DIR__.'/../Routes/web.php');
        Route::middleware(['web', 'admin', PreventRequestsDuringMaintenance::class])->group(__DIR__.'/../Routes/api.php');

        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'vipos');

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'vipos');

        Blade::anonymousComponentPath(__DIR__.'/../Resources/views/components', 'vipos');

        $this->publishes([
            __DIR__.'/../Config/vipos.php' => config_path('vipos.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../Resources/assets' => public_path('vendor/vipos'),
        ], 'public');
    }

    /**
     * Register package config.
     */
    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/vipos.php',
            'vipos'
        );
    }
}