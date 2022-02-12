<?php

declare(strict_types=1);

namespace App\Providers;

use App\Nova\Metrics\NewUsers;
use App\Nova\Metrics\UsersPerDay;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        if (class_exists('\Barryvdh\Debugbar\Facade')) {
            Nova::serving(function (): void {
                \Barryvdh\Debugbar\Facade::disable();
            });
        }
    }

    protected function routes(): void
    {
        Nova::routes()->register();
    }

    protected function gate(): void
    {
        Gate::define('viewNova', fn ($user) => $user->can('access-nova'));
    }

    protected function cards(): array
    {
        return [
            (new NewUsers())->canSeeWhen('access-nova'),
            (new UsersPerDay())->canSeeWhen('access-nova'),
        ];
    }

    protected function dashboards(): array
    {
        return [];
    }

    public function tools(): array
    {
        return [];
    }
}
