<?php

namespace Masuresh124\AuthIdle\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Masuresh124\AuthIdle\Traits\AuthIdleTrait;

class AuthIdleMiddleware
{
    use AuthIdleTrait;
    public function handle(Request $request, Closure $next)
    {
        if (!$this->validateIdle($request)) {
            return $this->redirectToLogin($request);
        }
        return $next($request);
    }
}
