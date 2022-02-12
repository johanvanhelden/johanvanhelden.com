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

        Horizon::night();
    }

    protected function gate(): void
    {
        Gate::define('viewHorizon', fn ($user) => $user->can('access-horizon'));
    }
}
