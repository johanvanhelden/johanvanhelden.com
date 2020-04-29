<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

/**
 * Inertia service provider.
 */
class InertiaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Inertia::setRootView('layouts.app');

        Inertia::share([
            'app' => [
                'name'  => Config::get('app.name'),
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

        if (!app()->environment(config('constants.environment.testing'))) {
            Inertia::version(function () {
                return md5_file(public_path('mix-manifest.json'));
            });
        }
    }
}
