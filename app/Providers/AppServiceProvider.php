<?php

namespace App\Providers;

use App\Cluster;
use App\Program;
use App\Semester;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Returns the current semester to the specified views
        View::composer([
            'student.show',
            'enrollment.index',
            'enrollment.create',
            'enrolled-student.index',
            'student-enrollment.index',
            'tracking.index',
            'tracking.show',
            'trackingStep.show',
        ], function($view) {
        $view->with('currentSemester', Semester::where('current', 1)->first());
        });


        // Returns clusters to the specified views
        View::composer([
            'user.coordinator.create',
            'user.edit',
            'program.create',
            'program.edit',
            'faculty.create',
            'faculty.edit',
            'student.create',
            'student.edit',
            'report.index',
        ], function ($view) {
            $view->with('clusters', Cluster::orderBy('cluster')->get());
        });


        // Returns programs to the specified views
        View::composer([
            'course.create',
            'course.edit',
            'enrollment.create',
        ], function ($view) {
            $view->with('programs', Program::orderBy('program')->get());
        });
    }
}
