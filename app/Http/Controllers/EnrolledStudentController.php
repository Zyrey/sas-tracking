<?php

namespace App\Http\Controllers;

use App\Enrollment;
use App\Repositories\SemesterRepository;
use Illuminate\Http\Request;
use App\Student;
use App\EnrolledCourse;
use App\Semester;

class EnrolledStudentController extends Controller
{

    /**
     * @var SemesterRepository
     */
    private $currentSemester;

    public function __construct(SemesterRepository $semesterRepository)
    {
        $this->currentSemester = $semesterRepository->current();
    }


    public function index()
    {
        return view('enrolled-student.index');
    }

    public function enrolledstudent(){
        /*$enrollments = collect();
        // Check if currentSemester has a value
        if ($this->currentSemester) {
            $enrollments = Enrollment::with('student', 'program')
            ->whereHas('enrolledCourses', function ($q) {
                return $q->where('semester_id', $this->currentSemester->id);
            })
                ->whereStatus(1)
                ->get();
        }*/
        $enrollments = Student::join('enrollments','enrollments.student_id_number','students.id_number')
        ->join('enrolled_courses','enrolled_courses.enrollment_id','enrollments.id')
        ->join('semesters','enrolled_courses.semester_id','semesters.id')
        ->join('programs','enrollments.program_id','programs.id')
        ->where('semesters.current','1')
        ->select('students.first_name','enrollments.month_start','enrollments.year_start as year_start2','students.last_name','students.middle_name','students.id_number','semesters.year_end','semesters.year_start','semesters.term','programs.program','enrolled_courses.enrollment_id','programs.id as program_id')
        ->groupBy('enrolled_courses.semester_id','students.id_number')
        ->get();
        return $enrollments;
    }

    public function createEnroll(Request $request){
        $check_id = Student::where('id_number',$request['student'])
        ->get();
        $student_id = $request['student'];
        $courses = $request['course'];
        
        if($check_id->count()>0){
            $checkIfEnrolled = Enrollment::select('student_id_number')
            ->join('enrolled_courses','enrolled_courses.enrollment_id','enrollments.id')
            ->where('enrollments.student_id_number',$student_id)
            ->where('enrolled_courses.semester_id',$request['semester'])
            ->get();
            if($checkIfEnrolled->count()>0){
                return response(json_encode('Student has already enrolled for the selected school year semester'));
            }else{
                $newEnroll = Enrollment::create([
                    'student_id_number' => $student_id,
                    'program_id' => $request['program'],
                    'month_start' => '8',
                    'year_start' => '2020'
                ]);
                $newEnroll->save();
                $getEnrollId = $newEnroll->id;
                foreach($courses as $course){
                    $newEnrolled_courses = EnrolledCourse::create([
                        'enrollment_id' => $getEnrollId,
                        'semester_id' => $request['semester'],
                        'course_id' => $course
                    ]);
                    $newEnrolled_courses->save();
                }
                return response(json_encode('Student has been successfully enrolled to the semester'));
            }
        }else{
            $newStudent = Student::create([
                'id_number' => $student_id,
                'first_name' => $request['fname'],
                'last_name' => $request['lname'],
                'middle_name' => $request['mname'],
                'email' => $request['email'],
                'contact_number' => $request['contact']
            ]);
            $newEnroll = Enrollment::create([
                'student_id_number' => $student_id,
                'program_id' => $request['program'],
                'month_start' => '8',
                'year_start' => '2020'
            ]);
            $newEnroll->save();
            $newEnrollId = $newEnroll->id;
            foreach($courses as $course){
                $newEnrolled_courses = EnrolledCourse::create([
                    'enrollment_id' => $newEnrollId,
                    'semester_id' => $request['semester'],
                    'course_id' => $course
                ]);
                $newEnrolled_courses->save();
            }
            return response(json_encode('Student has been successfully enrolled to the semester'));
        }
        return 'Error';
    }

    public function checkId(Request $request){
        $student_data = Student::where('id_number',$request['id'])
        ->get();
        if(count($student_data)===0){
            
        }else{
            return $student_data;
        }
    }

    public function getEnrolledCourses(Request $request){
        $current_sem = Semester::where('current',1)
        ->pluck('id');
        $e_courses = EnrolledCourse::join('courses','courses.id','enrolled_courses.course_id')
        ->join('course_levels','course_levels.id','courses.course_level_id')
        ->select('courses.course_number','courses.descriptive_title','course_levels.course_level','enrolled_courses.course_status','enrolled_courses.enrollment_status','enrolled_courses.id')
        ->where('enrollment_id',$request['id'])
        ->where('enrolled_courses.semester_id',$current_sem[0])
        ->get();
        return $e_courses;
    }

}
