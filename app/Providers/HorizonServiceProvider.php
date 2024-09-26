<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        $horizonEmail = config('constants.horizon-notify-email');
        if (is_string($horizonEmail)) {
            Horizon::routeMailNotificationsTo($horizonEmail);
        }
    }

    protected function gate(): void
    {
        Gate::define('viewHorizon', fn ($user) => $user->can('access-horizon'));
    }
}
