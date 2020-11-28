<?php

namespace App\Http\Controllers;

use App\Enrollment;
use App\Repositories\SemesterRepository;
use App\Student;

class StudentEnrollmentController extends Controller
{
    private $currentSemester;

    public function __construct(SemesterRepository $semesterRepository)
    {
        $this->currentSemester = $semesterRepository->current();
    }


    public function index(Student $student)
    {
        $enrollments = collect();
        // get the current enrollments of the student
        if ($this->currentSemester) {
            $enrollments = Enrollment::whereHas('enrolledCourses', $filter = function ($query) {
                return $query->where('semester_id', $this->currentSemester->id);
            })
                ->with(['enrolledCourses' => function ($query) {
                    return $query->where('semester_id', $this->currentSemester->id)
                        ->with('course.courseLevel');
                }])
                ->where('student_id_number', $student->id_number)
                ->where('status', 1)
                ->get();
        }
        // dd('$student','$enrollments');
        return view('student-enrollment.index', compact('student', 'enrollments'));
        // return view('student-enrollment.index');
    }

    // public function enrolledcourselist(Student $student){
    //     $enrollments = collect();
    //     // get the current enrollments of the student
    //     if ($this->currentSemester) {
    //         $enrollments = Enrollment::whereHas('enrolledCourses', $filter = function ($query) {
    //             return $query->where('semester_id', $this->currentSemester->id);
    //         })
    //             ->with(['enrolledCourses' => function ($query) {
    //                 return $query->where('semester_id', $this->currentSemester->id)
    //                     ->with('course.courseLevel');
    //             }])
    //             ->where('student_id_number', $student->id_number)
    //             ->where('status', 1)
    //             ->get();
    //     }
    //     return $enrollments;
    // }
}
