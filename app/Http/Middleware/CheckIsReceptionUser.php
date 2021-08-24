<?php

namespace App\Http\Middleware;

use App\Exceptions\UnauthorizedException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CheckIsReceptionUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws UnauthorizedException
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Gate::check('is-reception'))
            throw new UnauthorizedException();
        return $next($request);
    }
}
