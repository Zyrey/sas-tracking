<?php

namespace App\Http\Controllers\Auth\superadmin\passwords;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest:superadmin');
    }


    // Define broker as superadmins
    public function broker()
    {
        return Password::broker('superadmins');
    }


    // Override default showLinkRequestForm
    public function showLinkRequestForm()
    {
        return view('superadmin.auth.passwords.email');
    }
}
