<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request                                       $request
     * @param Closure(\Illuminate\Http\Request): (Response|RedirectResponse) $next
     * @param string|null                                                    ...$guards
     */
    public function handle(Request $request, Closure $next, ...$guards): Response | RedirectResponse | JsonResponse
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(url('/'));
            }
        }

        return $next($request);
    }
}
