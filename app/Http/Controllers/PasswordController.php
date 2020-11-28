<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('password.change');
    }


    public function changePassword(Request $request)
    {
        // Check if the entered current_password is the user's password
        if (!(Hash::check($request->get('current_password'), Auth::user()->getAuthPassword())))
        {
            // Return error if current_password is incorrect
            return back()->with('error', 'Your current password is incorrect.');
        }

        // Check if the entered new_password is not the same as the current_password
        if (strcmp($request->get('current_password'), $request->get('new_password')) == 0)
        {
            // Return error
            return back()->with('error', 'Your current password must not be the same as the new password.');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        Auth::user()->update([
            'password' => bcrypt($request->get('new_password')),
        ]);

        if (Auth()->guard('superadmin')->check())
        {
            return redirect(route('superadmin.show', Auth()->user()->email))->with('message', 'Password changed successfully.');
        } else {
            return redirect(route('user.show', Auth()->user()->email))->with('message', 'Password changed successfully.');
        }
    }
}
