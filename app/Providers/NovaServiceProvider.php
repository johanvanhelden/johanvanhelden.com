<?php

namespace App\Providers;

use App\Nova\Metrics\NewUsers;
use App\Nova\Metrics\UsersPerDay;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

/**
 * The Nova service provider.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        parent::boot();

        if (class_exists('\Barryvdh\Debugbar\Facade')) {
            Nova::serving(function () {
                \Barryvdh\Debugbar\Facade::disable();
            });
        }
    }

    /**
     * Register the Nova routes.
     */
    protected function routes()
    {
        Nova::routes()->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return $user->can('access-nova');
        });
    }

    /**
     * Get the cards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new NewUsers(),
            new UsersPerDay(),
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }
}
