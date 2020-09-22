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
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        //
    }

    /**
     * Report or log an exception.
     *
     * @throws \Exception
     */
    public function report(Throwable $exception): void
    {
        $this->handleSentry($exception);

        parent::report($exception);
    }

    protected function handleSentry(Throwable $exception): void
    {
        if (! $this->shouldReport($exception)) {
            return;
        }

        if (App::environment(config('constants.environment.development'))) {
            return;
        }

        if (! App::bound('sentry')) {
            return;
        }

        App::get('sentry')->captureException($exception);
    }
}
