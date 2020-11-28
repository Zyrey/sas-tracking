<?php

namespace App\Providers;

use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Cluster' => 'App\Policies\ClusterPolicy',
        'App\Program' => 'App\Policies\ProgramPolicy',
        'App\Course' => 'App\Policies\CoursePolicy',
        'App\Faculty' => 'App\Policies\FacultyPolicy',
        'App\Student' => 'App\Policies\StudentPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function ($user) {
            return $user->is_admin;
        });

        Passport::routes();
    }
}
