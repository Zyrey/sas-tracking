<?php

namespace App\Http\Controllers\Auth\superadmin\passwords;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
   |--------------------------------------------------------------------------
   | Password Reset Controller
   |--------------------------------------------------------------------------
   |
   | This controller is responsible for handling password reset requests
   | and uses a simple trait to include this behavior. You're free to
   | explore this trait and override any methods you wish to tweak.
   |
   */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/superadmin';

    public function __construct()
    {
        $this->middleware('guest:superadmin');
    }

    // Define guard as superadmin
    protected function guard()
    {
        return Auth::guard('superadmin');
    }

    // Define broker
    public function broker()
    {
        return Password::broker('superadmins');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    // Override default showResetForm
    public function showResetForm(Request $request, $token = null)
    {
        return view('superadmin.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
