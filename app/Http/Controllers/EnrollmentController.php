<?php

namespace App\Http\Controllers;

use App\Course;
use App\EnrolledCourse;
use App\Http\Requests\StoreEnrollment;
use App\Enrollment;
use App\Repositories\SemesterRepository;
use App\Student;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    private $currentSemester;

    public function __construct(SemesterRepository $semesterRepository)
    {
        $this->currentSemester = $semesterRepository->current();
    }


    public function index()
    {
        return view('enrollment.index');
    }

    public function eTrack(Request $request){
        //return view('enrollment.track');
        $id = $request['id'];
        return view('enrollment.track', compact('id'));
    }

    public function list(){
        $enrolledCourses = collect();
        // Check if currentSemester has a value
        if ($this->currentSemester) {
            $enrolledCourses = EnrolledCourse::with('semester', 'course', 'enrollment.program')
                ->where('semester_id', $this->currentSemester->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        return $enrolledCourses;
    }

    public function saveEnrollmentStatus(Request $request){
        $enrollment= EnrolledCourse::find($request['id']);
        $enrollment->enrollment_status = $request['enrollment_status'];
        $enrollment->save();
        return $enrollment;
    }

    public function saveCourseStatus(Request $request){
        $grade = $request['grade'];
        $enrollment= EnrolledCourse::find($request['id']);
        $enrollment->course_status = $request['course_status'];
        $enrollment->grade = $grade;
        $enrollment->save();
        return $enrollment;
    }

    public function create(Enrollment $enrollment, Student $student)
    {
        $courses = Course::orderBy('course_number', 'asc')->get();

        return view('enrollment.create', compact('enrollment', 'student', 'courses'));
    }


    public function store(StoreEnrollment $request)
    {
        // If no current semester, return forbidden
        if (empty($this->currentSemester)) {
            abort(403);
        }

        // Check if an active record of the id_number and program_id exist on the enrollment
        $existingEnrollment = Enrollment::where('student_id_number', $request->student_id_number)
            ->where('program_id', $request->program_id)
            ->whereStatus(1)
            ->first();

        // Update if there is an active record, otherwise create a new one.
        if ($existingEnrollment) {
            $enrollment = $existingEnrollment;
        } else {
            $enrollment = Enrollment::Create($request->only(['student_id_number', 'program_id']));
        }


        // Update or create the selected Courses
        foreach ($request->courses as $key => $courseId) {
            // Get Previous semester of the enrollment then Count how many times the course has been taken.
            $count = $enrollment->enrolledCourses->where('semester_id', '<', $this->currentSemester->id)->where('course_id', $courseId)->count();
            $enrollment->enrolledCourses()->updateOrCreate([
                'semester_id' => $this->currentSemester->id,
                'course_id' => $courseId,
                'take_number' => $count + 1,
            ]);
        }

        return redirect(route('enrollments.index'))->with('message', 'Enrollment successful.');
    }


    public function editResidencyPeriod(Student $student, Enrollment $enrollment)
    {
        return view('residencyPeriod.edit', compact('student', 'enrollment'));
    }


    public function updateResidencyPeriod(Student $student, Enrollment $enrollment, Request $request)
    {
        $request->validate([
            'month_start' => 'required|integer|between:1,12',
            'year_start' => 'bail|required|digits:4|integer|min:2000|max:'.(date('Y')),
        ]);

        $enrollment->update($request->all());

        return redirect(route('students.show', $student->id_number))
            ->with('message', 'Residency period updated successfully.');
    }

}
