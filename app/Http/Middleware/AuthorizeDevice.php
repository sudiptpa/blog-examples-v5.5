<?php

namespace App\Http\Middleware;

use App\Authorize;
use App\Mail\AuthorizeDevice as AuthorizeMail;
use Closure;
use Illuminate\Support\Facades\Mail;

/**
 * Class AuthorizeDevice
 * @package App\Http\Middleware
 */
class AuthorizeDevice
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
        if (Authorize::inactive() && auth()->check()) {
            $authorize = Authorize::make();

            if ($authorize->noAttempt()) {
                Mail::to($request->user())
                    ->send(new AuthorizeMail($authorize));

                $authorize->increment('attempt');
            }

            return response()->view('auth.authorize');
        }

        return $next($request);
    }
}
