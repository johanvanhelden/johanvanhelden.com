<?php

namespace App\Providers;

use App\Rules\CurrentPassword;
use App\Rules\DbString;
use App\Rules\StrongPassword;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

/**
 * Our validation service provider.
 */
class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Validator::extend('current_password', CurrentPassword::class . '@passes');
        Validator::extend('strong_password', StrongPassword::class . '@passes');

        Validator::extend('db_string', DbString::class . '@passes');

        // replace the message
        $length = config('validation.db_string.length');
        Validator::replacer('db_string', function ($message) use ($length) {
            return str_replace(':max', (string) $length, $message);
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}
