<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // Checks if login as an admin then it will redirect it to admin home page when accessing admin login.
        // It will not let logged in admin to access login form.
        switch ($guard){
            case 'superadmin':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('superadmin.home');
                }
                break;

            case 'admin':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('admin.home');
                }
                break;

            case 'coordinator':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('coordinator.home');
                }
                break;

            default:
                if (Auth::guard($guard)->check()) {
                    return redirect(RouteServiceProvider::HOME);
                }
                break;
        }

        return $next($request);
    }
}
