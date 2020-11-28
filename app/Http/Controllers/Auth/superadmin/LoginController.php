<?php

namespace App\Http\Controllers\Auth\superadmin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    // Only allows superadmin guests for using the login functionality
    // Except the logout function because a guest cannot logout, only logged in users can logout.
    public function __construct()
    {
        $this->middleware('guest:superadmin')->except('logout');
    }

    //  Shows login form
    public function showLoginForm()
    {
        return view('superadmin.auth.login');
    }

    //  Validates superadmin credentials then redirect to superadmin homepage
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('superadmin')->attempt($request->only('email', 'password'),$request->filled('remember'))) {
            return redirect()->intended(route('superadmin.home'));
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    // Overrides the default logout, only logout users using the superadmin guard
    public function logout()
    {
        Auth::guard('superadmin')->logout();

        return redirect('/');
    }
}


