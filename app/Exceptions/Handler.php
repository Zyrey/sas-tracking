<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // If using the admin guard then it will redirect the user to the admin login page
        // Else if it using the default guard 'web' then it will redirect the user to the user login page
        if($exception instanceof AuthenticationException){
            $guard = Arr::get($exception->guards(), 0);
            switch($guard){
                case 'superadmin':
                    return  redirect(route('superadmin.login'));
                    break;

                case 'admin':
                    return redirect(route('admin.login'));
                    break;

                case 'coordinator':
                    return redirect(route('coordinator.login'));
                    break;

                default:
                    return redirect(route('login'));
                    break;
            }
        }

        return parent::render($request, $exception);
    }
}
