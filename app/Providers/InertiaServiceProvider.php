<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class InertiaServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Inertia::setRootView('layouts.app');

        Inertia::share([
            'app' => [
                'name'  => config('app.name'),
                'isDev' => App::environment(config('constants.environment.development')),
            ],
            'errors' => function () {
                $errors = collect();

                if (Session::get('errors')) {
                    $errors = Session::get('errors')->getBag('default')->getMessages();
                }

                return $errors;
            },
            'flashNotifications' => function () {
                return Session::get('flash_notification');
            },
            'csrfToken' => function () {
                return Session::token();
            },
            'expandedHeader' => false,
        ]);

        if (!App::environment(config('constants.environment.testing'))) {
            Inertia::version(function () {
                return md5_file(public_path('mix-manifest.json'));
            });
        }
    }
}
