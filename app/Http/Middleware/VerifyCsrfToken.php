<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Log;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];

    /**
     * Handle an incoming request.
     *
     * Overwritten so we can handle this in a more friendly way for the end user.
     *
     * @param Request $request
     *
     * @throws \Illuminate\Session\TokenMismatchException
     */
    public function handle($request, Closure $next): mixed
    {
        try {
            return parent::handle($request, $next);
        } catch (TokenMismatchException $exception) {
            Log::info('Session expired', [$exception]);

            flash(__('message.session_expired'))->error();

            return redirect()->route('page.home');
        }
    }
}
