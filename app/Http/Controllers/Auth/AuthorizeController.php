<?php

namespace App\Http\Controllers\Auth;

use App\Authorize;
use App\Http\Controllers\Controller;
use App\Mail\AuthorizeDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

/**
 * Class AuthorizeController
 * @package App\Http\Controllers\Auth
 */
class AuthorizeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *  Validate the token for the Authorization.
     *
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function verify($token = null)
    {
        if (Authorize::validateToken($token)) {
            return Redirect::route('dashboard')->with([
                'success' => 'Awesome ! you are now authorized !',
            ]);
        }

        return Redirect::route('login')->with([
            'error' => "Oh snap ! the authorization token is either expired or invalid. Click on Email didn't arraive ? again",
        ]);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if (Authorize::inactive() && auth()->check()) {
            $authorize = Authorize::make()
                ->resetAttempt();

            Mail::to($request->user())
                ->send(new AuthorizeDevice($authorize));

            $authorize->increment('attempt');

            return view('auth.authorize');
        }
    }
}
