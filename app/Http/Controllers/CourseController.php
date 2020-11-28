<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourse;
use App\Http\Requests\UpdateCourse;
use App\Program;
use App\Course;
use App\CourseLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index()
    {
        return view('course.index');
    }

    public function list(){
        $courses = Course::with('program')
            ->with('courseLevel')
            ->orderBy('id')
            ->get();
        
        return $courses;
    }

    public function sCourse(Request $request){
        $courses = Course::where('program_id','=',$request['id'])
        ->get();
        return $courses;
    }

    public function courseLevelList(){
        $courseLevel = CourseLevel::get();
        return $courseLevel;
    }

    public function updateCourse(Request $request){
        $course = Course::find($request['id']);
        $course->course_number = $request['course_number'];
        $course->descriptive_title = $request['descriptive_title'];
        $course->program_id = $request['program']['id'];
        $course->course_level_id = $request['course_level']['id'];
        $course->save();
        
    }

    public function createCourse(Request $request){
        $this->validate($request,[
            'course_number' => 'required|unique:courses,course_number'
        ]);

        return Course::create([
            'program_id' => $request['program'],
            'course_level_id' => $request['course_level'],
            'course_number' => $request['course_number'],
            'descriptive_title' => $request['descriptive_title'],
            'units' => $request['units']
        ]);
    }

    public function create(Course $course)
    {
        $courseLevels = CourseLevel::orderBy('course_level', 'asc')->get();

        return view('course.create', compact('course', 'courseLevels'))
            ->with('message', 'Course has been created successfully.');
    }


    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'course_level_id' => 'required|exists:course_levels,id',
            'course_number' => 'required|string|min:3|max:225|unique:courses|regex:/^[A-Za-z0-9\s\-_]+$/',
            'descriptive_title' => 'required|string|min:3|max:225|regex:/^[A-Za-z0-9\s\-_]+$/',
            'units' => 'required|integer|min:1|max:15',
        ]);

        $course = Course::create($request->all());
        return redirect(route('courses.show', $course->id));
    }


    public function show(Course $course)
    {
        $this->authorize('view', $course);

        $course->load('courseLevel.steps.requirements');

        return view('course.show', compact('course'));
    }


    public function edit(Course $course)
    {
        $this->authorize('update', $course);

        $courseLevels = CourseLevel::orderBy('course_level', 'asc')->get();

        return view('course.edit', compact('course', 'courseLevels'));
    }


    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'course_level_id' => 'required|exists:course_levels,id',
            'descriptive_title' => 'required|string|min:3|max:225|regex:/^[A-Za-z0-9\s\-_]+$/',
            'course_number' => [
                'required', 'string', 'min:3', 'max:225', 'regex:/^[A-Za-z0-9\s\-_]+$/',
                Rule::unique('courses')->ignore($course->id),
            ]
        ]);

        $course->update($request->all());
        return redirect(route('courses.show', $course->id))
            ->with('message', 'Course has been updated successfully.');
    }

}
