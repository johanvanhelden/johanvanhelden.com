<?php

declare(strict_types=1);

namespace App\Providers;

use App\Rules\CurrentPassword;
use App\Rules\DbString;
use App\Rules\StrongPassword;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Validator::extend('current_password', CurrentPassword::class . '@passes');
        Validator::extend('strong_password', StrongPassword::class . '@passes');

        Validator::extend('db_string', DbString::class . '@passes');

        Validator::replacer('db_string', function ($message) {
            $length = config('validation.db_string.length');

            return str_replace(':max', (string) $length, $message);
        });
    }
}
