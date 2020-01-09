<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * App service provider.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind('path.public', function () {
            return base_path() . '/public_html';
        });

        if (app()->environment(config('constants.environment.development'))) {
            $this->app->register(\Laravel\Dusk\DuskServiceProvider::class);
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }
}
