<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function authenticated(\Illuminate\Http\Request $request, $user)
    {
        $user->generateTwoFactorCode();
        $user->notify(new \App\Notifications\TwoFactorCode());
        return redirect()->route('verify.index');
    }

    public function redirectTo()
    {
        // This won't be called if authenticated() redirects, 
        // but we keep it as a fallback or for other auth flows.
        if (Auth::user()->role == 'user') {
            return '/user/dashboard';
        } elseif (Auth::user()->role == 'admin') {
            return '/admin/dashboard';
        }
    }
}
