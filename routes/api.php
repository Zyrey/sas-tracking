<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:api')->group(function () {
    Route::get('events', 'API\EventController@index');
    Route::post('events', 'API\EventController@store');
    Route::put('events/{id}', 'API\EventController@update');
    Route::delete('events/{id}', 'API\EventController@destroy');
// });

//student module
Route::get('student.index', 'StudentController@index')->name('student.index');
Route::get('studentlist', 'StudentController@list')->name('studentlist');
Route::get('student/{id_number}','StudentController@show')->name('details');
Route::post('student/{id_number}','StudentController@update')->name('edit');
Route::post('add','StudentController@store')->name('add');
// Route::resource('index','StudentController');


//cluster module
Route::get('clusterlist', 'ClusterController@list')->name('clusterlist');

//program module
Route::get('programlist', 'ProgramController@list')->name('programlist');

//course level
Route::get('courseLevel', 'CourseController@courseLevelList')->name('courseLevel');

//course module
Route::get('courselist', 'CourseController@list')->name('courselist');

//get course by course_id
Route::post('sCourse/{id}', 'CourseController@sCourse')->name('sCourse');

//course update
Route::post('updateCourse/{id}', 'CourseController@updateCourse')->name('updateCourse');

//course create
Route::post('createCourse', 'CourseController@createCourse')->name('createCourse');

//enrollment
Route::get('enrollmentlist', 'EnrollmentController@list')->name('enrollmentlist');

//get step data
Route::post('getStepData/{id}', 'TrackingController@getStepData')->name('getStepData');

//complete step
Route::post('completeStep/{id}', 'TrackingController@completeStep')->name('completeStep');

//incomplete step
Route::post('incompleteStep/{id}', 'TrackingController@incompleteStep')->name('incompleteStep');

//deactive step
Route::post('deacStep/{id}', 'TrackingController@deacStep')->name('deacStep');

//activate step
Route::post('activateStep/{id}', 'TrackingController@activateStep')->name('activateStep');

//delete step
Route::post('deleteStep/{id}', 'TrackingController@deleteStep')->name('deleteStep');

//save edited step
Route::post('saveEditStep', 'TrackingController@saveEditStep')->name('saveEditStep');

//get semesters
Route::get('semesters', 'SemesterController@list')->name('semesters');

//enrolled students
Route::get('enrolledstudent', 'EnrolledStudentController@enrolledstudent')->name('enrolledstudent');

//enroll student
Route::post('newEnroll', 'EnrolledStudentController@createEnroll')->name('newEnroll');

//get students enrolled courses
Route::post('getEnrolledCourses/{id}', 'EnrolledStudentController@getEnrolledCourses')->name('getEnrolledCourses');

//get id data if it exists
Route::post('checkId/{id}', 'EnrolledStudentController@checkId')->name('checkId');

//track enrollment
Route::post('trackEnrollment/{id}', 'TrackingController@trackEnrollment')->name('trackEnrollment');

//get enrollment steps
Route::post('getTrack/{id}', 'TrackingController@getTrack')->name('getTrack');

//save new step
Route::post('saveNewStep/{id}', 'TrackingController@saveNewStep')->name('saveNewStep');

//save new step
Route::post('duplicateStep/{id}', 'TrackingController@duplicateStep')->name('duplicateStep');

//get steps per track
Route::post('getStepsPerTrack/{id}', 'TrackingController@getStepsPerTrack')->name('getStepsPerTrack');

//get steps per track
Route::post('getTrackData/{id}', 'TrackingController@getTrackData')->name('getTrackData');

//deactivate track
Route::post('deactivateTrack/{id}', 'TrackingController@deactivateTrack')->name('deactivateTrack');

//activate track
Route::post('activateTrack/{id}', 'TrackingController@activateTrack')->name('activateTrack');

//create new tracking
Route::post('newTracking/{id}', 'TrackingController@newTracking')->name('newTracking');

//get faculties
Route::get('getFaculties', 'FacultyController@getFaculties')->name('getFaculties');

//get clusters
Route::get('getClusters', 'FacultyController@getClusters')->name('getClusters');

//get institutions
Route::get('getInstitutions', 'FacultyController@getInstitutions')->name('getInstitutions');

//save edited faculty
Route::post('saveEditFaculty/{id}', 'FacultyController@saveEditFaculty')->name('saveEditFaculty');

//save new faculty
Route::post('newFaculty', 'FacultyController@newFaculty')->name('newFaculty');

//save enrollment status
Route::post('saveEnrollmentStatus/{id}', 'EnrollmentController@saveEnrollmentStatus')->name('saveEnrollmentStatus');

//save course status/grade
Route::post('saveCourseStatus/{id}', 'EnrollmentController@saveCourseStatus')->name('saveCourseStatus');

//get enrollment status
Route::post('enrollmentStatus/{id}', 'TrackingController@enrollmentStatus')->name('enrollmentStatus');

//delete enrolled course
Route::post('deleteEnrolledCourse/{id}', 'EnrolledCourseController@deleteEnrolledCourse')->name('deleteEnrolledCourse');

//delete enrolled course
Route::post('createProgram', 'ProgramController@createProgram')->name('createProgram');

//saved edit program
Route::post('saveProgram', 'ProgramController@saveProgram')->name('saveProgram');

//save edited student
Route::post('saveEditStudent', 'StudentController@saveEditStudent')->name('saveEditStudent');

//save new student
Route::post('saveNewStudent', 'StudentController@saveNewStudent')->name('saveNewStudent');

//check student id
Route::post('checkIdStudent/{id}', 'StudentController@checkIdStudent')->name('checkIdStudent');

//save update sem
Route::post('updateSem', 'SemesterController@updateSem')->name('updateSem');

//delete requirement
Route::post('deleteReq/{id}', 'TrackingController@deleteReq')->name('deleteReq');

//get advisers
Route::get('getAdvisers', 'TrackingController@getAdvisers')->name('getAdvisers');

//save Adviser
Route::post('saveAdviser', 'TrackingController@saveAdviser')->name('saveAdviser');

//get faculty requirement if exists
Route::post('getFacultyReq/{id}', 'TrackingController@getFacultyReq')->name('getFacultyReq');

//get faculty requirement if exists
Route::post('saveFile', 'TrackingController@saveFile')->name('saveFile');

//save Adviser
Route::post('assignPanel', 'TrackingController@savePanel')->name('assignPanel');

//check faculty reqs
Route::post('checkReqFaculty/{id}', 'FacultyController@checkReqFaculty')->name('checkReqFaculty');

//get user data
Route::post('getUserData/{email}', 'UserController@getUserData')->name('getUserData');

//get roles
Route::get('getRoles', 'UserController@getRoles')->name('getRoles');

//save edited user data
Route::post('saveEditedUser', 'UserController@saveEditedUser')->name('saveEditedUser');

//save topic for enrollment
Route::post('saveTopic', 'TrackingController@saveTopic')->name('saveTopic');

//get faculty requirement if exists
Route::post('getTopicReq/{id}', 'TrackingController@getTopicReq')->name('getTopicReq');

//save sched for enrollment
Route::post('saveSched', 'TrackingController@saveSched')->name('saveSched');

//get sched requirement if exists
Route::post('getSchedReq/{id}', 'TrackingController@getSchedReq')->name('getSchedReq');

//save result for enrollment
Route::post('saveRes', 'TrackingController@saveRes')->name('saveRes');

//get sched requirement if exists
Route::post('getResultReq/{id}', 'TrackingController@getResultReq')->name('getResultReq');

//get external panel
Route::get('getExternalPanel', 'TrackingController@getExternalPanel')->name('getExternalPanel');

//get internal panel
Route::get('getInternalPanel', 'TrackingController@getInternalPanel')->name('getInternalPanel');
//enrolled course
// Route::get('enrolledcourselist', 'StudentEnrollmentController@enrolledcourselist')->name('studentEnrollments.index');
// Route::get('enrolledcourse/{student}', 'StudentEnrollmentController@enrolledcourselist')->name('enrolledcourse');
