<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;
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
        $skipSentry = App::environment(config('constants.environment.development'));

        if (!$skipSentry && $this->shouldReport($exception)) {
            App::get('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $response = parent::render($request, $exception);

        if ($this->shouldGoToInertiaErrorPage($request, $response)) {
            return Inertia::render('Error', [
                'status' => $response->getStatusCode(),
            ])
            ->toResponse($request)
            ->setStatusCode($response->getStatusCode());
        }

        return $response;
    }

    /**
     * Determines if we should send the visitor to an Inertia error page.
     *
     * @param \Illuminate\Http\Request                                             $request
     * @param \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response $response
     */
    public function shouldGoToInertiaErrorPage($request, $response): bool
    {
        // on development environments we want to see the actual error
        if (App::environment(config('constants.environment.development'))) {
            return false;
        }

        return $request->header('X-Inertia') && $response->getStatusCode() >= 400;
    }
}
