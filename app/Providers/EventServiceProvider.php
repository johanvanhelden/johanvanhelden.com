<?php

declare(strict_types=1);

namespace App\Providers;

use App\Listeners\Auth\AfterLogin;
use App\Listeners\Auth\AfterLogout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Login::class  => [
            AfterLogin::class,
        ],
        Logout::class => [
            AfterLogout::class,
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
