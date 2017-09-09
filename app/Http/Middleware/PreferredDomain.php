<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;

/**
 * Class PreferredDomain
 * @package App\Http\Middleware
 */
class PreferredDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (starts_with($request->header('host'), 'www.')) {
            $host = str_replace('www.', '', $request->header('host'));
            $request->headers->set('host', $host);

            return Redirect::to($request->fullUrl());
        }

        return $next($request);
    }
}
