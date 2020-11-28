<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

// Default Authentication Routes
Auth::routes(['register' => false]);

// SuperAdmin Authentication Routes
Route::prefix('superadmin')->namespace('Auth\superadmin')->name('superadmin.')->group(function (){
    // login superadmin
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login')->name('login.submit');
    Route::get('/logout', 'LoginController@logout')->name('logout');
    // password reset superadmin
    Route::post('/password/email', 'passwords\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('/password/reset', 'passwords\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('/password/reset', 'passwords\ResetPasswordController@reset')->name('password.update');
    Route::get('/password/reset/{token}', 'passwords\ResetPasswordController@showResetForm')->name('password.reset');
});


// Users Account Routes
Route::middleware('auth:superadmin')->group(function() {
    // Superadmin Profile
    Route::get('superadmin', 'SuperadminController@index')->name('superadmin.home');
    Route::get('superadmin/{superadmin:email}', 'SuperadminController@show')->name('superadmin.show');

    // Users CRUD
    Route::get('admins', 'AccountController@adminIndex')->name('admins.index');
    Route::get('admins/create', 'AccountController@adminCreate')->name('admins.create');
    Route::get('GPCs', 'AccountController@coordinatorIndex')->name('coordinators.index');
    Route::get('GPCs/create', 'AccountController@coordinatorCreate')->name('coordinators.create');
    Route::post('users', 'AccountController@store')->name('users.store');
    Route::get('users/{user:email}', 'AccountController@show')->name('users.show');
    Route::get('users/{user:email}/edit', 'AccountController@edit')->name('users.edit');
    Route::patch('users/{user:id}', 'AccountController@update')->name('users.update');
    Route::patch('users/{user:id}/activate', 'AccountController@activate')->name('users.activate');
    Route::patch('users/{user:id}/deactivate', 'AccountController@deactivate')->name('users.deactivate');

    // Roles CRUD
    Route::resource('/roles', 'RoleController');

    // Clusters CRUD
    // Route::resource('clusters', 'ClusterController');
    Route::get('clusters.index', 'ClusterController@index')->name('clusters.index');
    
});

// Change Password
Route::middleware('auth:superadmin,web')->group(function () {
    Route::get('profile/{user:email}/changepassword', 'PasswordController@showChangePasswordForm')->name('changepassword');
    Route::post('profile/{user:id}/changepassword', 'PasswordController@changePassword')->name('changepassword');
});


// User Profile
Route::middleware('auth')->group(function () {
    Route::get('home', 'HomeController@index')->name('home');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('profile/{user:email}', 'UserController@show')->name('user.show');
    Route::get('profile/{user:email}/edit', 'UserController@edit')->name('user.edit');
    Route::patch('profile/{user:id}', 'UserController@update')->name('user.update');
});


Route::middleware('auth:web')->group(function () {
    Route::middleware('can:isAdmin')->group(function () {
        //semester
        Route::resource('/semesters', 'SemesterController');
        Route::patch('/semesters/{semester}/updateCurrentSemester', 'SemesterController@updateCurrentSemester')->name('semesters.updateCurrentSemester');

        //course level
        Route::resource('/courseLevels', 'CourseLevelController');

        //step
        Route::resource('/steps', 'StepController');
        Route::delete('/steps/{step}/requirements/{requirement}', 'StepController@deleteRequirement')->name('steps.deleteRequirement');

        //institution
        Route::resource('/institutions', 'InstitutionController');
    });

    // step
    // Route::get('step.index', 'StepController@index')->name('step.index');

    //track
    Route::get('TrackingShow', 'TrackingController@show')->name('track.show');
    //program
    Route::resource('/programs', 'ProgramController');

    //course
    Route::resource('/courses', 'CourseController');

    //faculty
    Route::resource('/faculties', 'FacultyController');
    Route::patch('/faculties/{faculty}/activate', 'FacultyController@activate')->name('faculties.activate');
    Route::patch('/faculties/{faculty}/deactivate', 'FacultyController@deactivate')->name('faculties.deactivate');
    Route::get('/faculties/{faculty}/deleteCourse/{course}', 'FacultyController@deleteCourse')->name('faculties.deleteCourse');
    Route::get('student.index', 'StudentController@index')->name('student.index');
    //student
    // Route::resource('/students', 'StudentController');
    Route::patch('/students/{student}/activate', 'StudentController@activate')->name('students.activate');
    Route::patch('/students/{student}/deactivate', 'StudentController@deactivate')->name('students.deactivate');
    Route::get('/students/{student}/updateStatus', 'StudentController@updateStatus')->name('students.updateStatus');

    //enrollments
    Route::resource('/enrollments', 'EnrollmentController');
    Route::get('/enrollmentTrack/{id}', 'EnrollmentController@eTrack');
    Route::get('students/{student}/enrollments/{enrollment}/residencyPeriod/edit', 'EnrollmentController@editResidencyPeriod')->name('enrollments.editResidencyPeriod');
    Route::put('students/{student}/enrollments/{enrollment}/residencyPeriod', 'EnrollmentController@updateResidencyPeriod')->name('enrollments.updateResidencyPeriod');

    //manage Students Currently Enrolled In A Semester
    Route::get('/currently-enrolled-students', 'EnrolledStudentController@index')->name('enrolledStudents.index');

    // current enrollments
    Route::get('/students/{student}/enrollments/', 'StudentEnrollmentController@index')->name('studentEnrollments.index');

    //View tracking step
    Route::get('/viewStep/{id}', 'TrackingController@viewStep');

    //current enrolled courses
    Route::get('/students/{student}/enrollments/{enrollment}/enrolled-courses/{enrolledCourse}/edit', 'EnrolledCourseController@edit')->name('enrolledCourses.edit');
    Route::put('/students/{student}/enrollments/{enrollment}/enrolled-courses/{enrolledCourse:id}', 'EnrolledCourseController@update')->name('enrolledCourses.update');
    Route::get('/students/{student}/enrollments/{enrollment}/enrolled-courses/{enrolledCourse}/edit-enrollment-status', 'EnrolledCourseController@editEnrollmentStatus')->name('enrolledCourses.editEnrollmentStatus');
    Route::put('/students/{student}/enrollments/{enrollment}/enrolled-courses/{enrolledCourse:id}/edit-enrollment-status', 'EnrolledCourseController@updateEnrollmentStatus')->name('enrolledCourses.updateEnrollmentStatus');
    Route::post('/students/{student}/enrollments/{enrollment}/enrolled-courses/{enrolledCourse:id}/comments', 'EnrolledCourseController@storeComment')->name('enrolledCourses.storeComment');
    Route::delete('/students/{student}/enrollments/{enrollment}/enrolled-courses/{enrolledCourse:id}/comments/{comment:id}', 'EnrolledCourseController@deleteComment')->name('enrolledCourses.deleteComment');


    Route::middleware('can:view,enrolledCourse')->group(function () {
        //tracking
        Route::get('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings', 'TrackingController@index')->name('trackings.index');
        Route::post('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}', 'TrackingController@store')->name('trackings.store');
        Route::get('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}', 'TrackingController@show')->name('trackings.show');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/activate', 'TrackingController@activate')->name('trackings.activate');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/deactivate', 'TrackingController@deactivate')->name('trackings.deactivate');
        Route::post('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse:id}/trackings/{tracking}/comments', 'TrackingController@storeComment')->name('trackings.storeComment');
        Route::delete('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse:id}/trackings/{tracking}/comments/{comment:id}', 'TrackingController@deleteComment')->name('trackings.deleteComment');

        //tracking-steps
        Route::get('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/completed', 'TrackingStepController@showCompleted')->name('trackingSteps.showCompleted');
        Route::get('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/create', 'TrackingStepController@create')->name('trackingSteps.create');
        Route::post('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps', 'TrackingStepController@store')->name('trackingSteps.store');
        Route::get('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}', 'TrackingStepController@show')->name('trackingSteps.show');
        Route::get('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/edit', 'TrackingStepController@edit')->name('trackingSteps.edit');
        Route::put('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}', 'TrackingStepController@update')->name('trackingSteps.update');
        Route::delete('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}', 'TrackingStepController@destroy')->name('trackingSteps.destroy');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/activate', 'TrackingStepController@activate')->name('trackingSteps.activate');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/deactivate', 'TrackingStepController@deactivate')->name('trackingSteps.deactivate');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/complete', 'TrackingStepController@complete')->name('trackingSteps.complete');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/incomplete', 'TrackingStepController@incomplete')->name('trackingSteps.incomplete');
        Route::post('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/duplicate', 'TrackingStepController@duplicate')->name('trackingSteps.duplicate');
        Route::post('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse:id}/trackings/{tracking}/tracking-steps/{trackingStep}/comments', 'TrackingStepController@storeComment')->name('trackingSteps.storeComment');
        Route::delete('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse:id}/trackings/{tracking}/tracking-steps/{trackingStep}/comments/{comment:id}', 'TrackingStepController@deleteComment')->name('trackingSteps.deleteComment');

        // StepDefault
        Route::get('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepDefault/create', 'StepDefaultController@create')->name('stepDefault.create');
        Route::post('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepDefault', 'StepDefaultController@store')->name('stepDefault.store');
        Route::get('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepDefault/{stepDefault}/edit', 'StepDefaultController@edit')->name('stepDefault.edit');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepDefault/{stepDefault}', 'StepDefaultController@update')->name('stepDefault.update');
        Route::delete('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepDefault/{stepDefault}/forms/{form}', 'StepDefaultController@deleteForm')->name('stepDefault.deleteForm');

        // Delete Step Requirement
        Route::delete('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}', 'StepRequirementController@destroy')->name('stepRequirements.destroy');

        // RequirementTopic
        Route::get('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementTopics/create', 'RequirementTopicController@create')->name('requirementTopics.create');
        Route::post('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementTopics/', 'RequirementTopicController@store')->name('requirementTopics.store');
        Route::get('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementTopics/{requirementTopic}/edit', 'RequirementTopicController@edit')->name('requirementTopics.edit');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementTopics/{requirementTopic}', 'RequirementTopicController@update')->name('requirementTopics.update');
        Route::delete('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementTopics/{requirementTopic}/forms/{form}', 'RequirementTopicController@deleteForm')->name('requirementTopics.deleteForm');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementTopics/{requirementTopic}/deactivate', 'RequirementTopicController@deactivate')->name('requirementTopics.deactivate');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementTopics/{requirementTopic}/activate', 'RequirementTopicController@activate')->name('requirementTopics.activate');

        // RequirementFile
        Route::get('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementFiles/create', 'RequirementFileController@create')->name('requirementFiles.create');
        Route::post('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementFiles', 'RequirementFileController@store')->name('requirementFiles.store');
        Route::get('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementFiles/{requirementFile}/edit', 'RequirementFileController@edit')->name('requirementFiles.edit');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementFiles/{requirementFile}', 'RequirementFileController@update')->name('requirementFiles.update');
        Route::delete('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementFiles/{requirementFile}/forms/{form}', 'RequirementFileController@deleteForm')->name('requirementFiles.deleteForm');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementFiles/{requirementFile}/deactivate', 'RequirementFileController@deactivate')->name('requirementFiles.deactivate');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementFiles/{requirementFile}/activate', 'RequirementFileController@activate')->name('requirementFiles.activate');

        // RequirementSchedule
        Route::get('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementSchedules/create', 'RequirementScheduleController@create')->name('requirementSchedules.create');
        Route::post('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementSchedules', 'RequirementScheduleController@store')->name('requirementSchedules.store');
        Route::get('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementSchedules/{requirementSchedule}/edit', 'RequirementScheduleController@edit')->name('requirementSchedules.edit');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementSchedules/{requirementSchedule}', 'RequirementScheduleController@update')->name('requirementSchedules.update');
        Route::delete('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementSchedules/{requirementSchedule}/forms/{form}', 'RequirementScheduleController@deleteForm')->name('requirementSchedules.deleteForm');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementSchedules/{requirementSchedule}/deactivate', 'RequirementScheduleController@deactivate')->name('requirementSchedules.deactivate');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementSchedules/{requirementSchedule}/activate', 'RequirementScheduleController@activate')->name('requirementSchedules.activate');

        // RequirementResult
        Route::get('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementResults/create', 'RequirementResultController@create')->name('requirementResults.create');
        Route::post('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementResults', 'RequirementResultController@store')->name('requirementResults.store');
        Route::get('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementResults/{requirementResult}/edit', 'RequirementResultController@edit')->name('requirementResults.edit');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementResults/{requirementResult}', 'RequirementResultController@update')->name('requirementResults.update');
        Route::delete('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementResults/{requirementResult}/forms/{form}', 'RequirementResultController@deleteForm')->name('requirementResults.deleteForm');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementResults/{requirementResult}/deactivate', 'RequirementResultController@deactivate')->name('requirementResults.deactivate');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementResults/{requirementResult}/activate', 'RequirementResultController@activate')->name('requirementResults.activate');

        // RequirementAdviser
        Route::get('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementAdvisers/create', 'RequirementAdviserController@create')->name('requirementAdvisers.create');
        Route::post('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementAdvisers', 'RequirementAdviserController@store')->name('requirementAdvisers.store');
        Route::get('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementAdvisers/{requirementAdviser}/edit', 'RequirementAdviserController@edit')->name('requirementAdvisers.edit');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementAdvisers/{requirementAdviser}', 'RequirementAdviserController@update')->name('requirementAdvisers.update');
        Route::delete('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementAdvisers/{requirementAdviser}/forms/{form}', 'RequirementAdviserController@deleteForm')->name('requirementAdvisers.deleteForm');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementAdvisers/{requirementAdviser}/deactivate', 'RequirementAdviserController@deactivate')->name('requirementAdvisers.deactivate');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementAdvisers/{requirementAdviser}/activate', 'RequirementAdviserController@activate')->name('requirementAdvisers.activate');

        // RequirementPanel
        Route::get('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementPanels/create', 'RequirementPanelController@create')->name('requirementPanels.create');
        Route::post('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementPanels', 'RequirementPanelController@store')->name('requirementPanels.store');
        Route::get('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementPanels/{requirementPanel}/edit', 'RequirementPanelController@edit')->name('requirementPanels.edit');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementPanels/{requirementPanel}', 'RequirementPanelController@update')->name('requirementPanels.update');
        Route::delete('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementPanels/{requirementPanel}/forms/{form}', 'RequirementPanelController@deleteForm')->name('requirementPanels.deleteForm');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementPanels/{requirementPanel}/deactivate', 'RequirementPanelController@deactivate')->name('requirementPanels.deactivate');
        Route::patch('/students/{student}/enrollments/{enrollment:id}/enrolled-courses/{enrolledCourse}/trackings/{tracking}/tracking-steps/{trackingStep}/stepRequirements/{stepRequirement}/requirementPanels/{requirementPanel}/activate', 'RequirementPanelController@activate')->name('requirementPanels.activate');
    });

});
