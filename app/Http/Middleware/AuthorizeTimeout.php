<?php

namespace App\Http\Middleware;

use App\Authorize;
use Closure;

/**
 * Class AuthorizeTimeout
 * @package App\Http\Middleware
 */
class AuthorizeTimeout
{
    /**
     * @var \App\Authorize
     */
    private $authorize;

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
            $this->authorize = Authorize::make();

            if ($this->timeout()) {
                auth()->guard()->logout();

                $request->session()->invalidate();

                return redirect('/');
            }
        }

        return $next($request);
    }

    /**
     * Determines if the authorize attempt is timed out.
     *
     * @return bool
     */
    private function timeout()
    {
        $waiting = $this->authorize
            ->created_at
            ->addMinutes(15);

        if (now() >= $waiting) {
            return true;
        }

        return false;
    }
}
