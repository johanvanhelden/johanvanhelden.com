<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\App;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $isDevelopment = App::environment(config('constants.environment.development'));

        $this->reportable(function (Throwable $exception) use ($isDevelopment): void {
            if (!$isDevelopment && App::bound('sentry')) {
                App::get('sentry')->captureException($exception);
            }
        });
    }
}
