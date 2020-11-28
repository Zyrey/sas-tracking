<?php

namespace App\Http\Controllers;

use App\CourseLevel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseLevelController extends Controller
{
    public function index()
    {
        $courseLevels = CourseLevel::orderBy('course_level', 'asc')->paginate(10);

        return view('courseLevel.index', compact('courseLevels'));
    }

    public function create(CourseLevel $courseLevel)
    {
        return view('courseLevel.create', compact('courseLevel'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_level' => 'required|string|min:3|max:225|unique:course_levels,course_level|regex:/^[A-Za-z\s]+$/',
        ]);

        $courseLevel = CourseLevel::create($validatedData);

        return redirect(route('courseLevels.show', $courseLevel->id));
    }

    public function show(CourseLevel $courseLevel)
    {
        return view('courseLevel.show', compact('courseLevel'));
    }


    public function edit(CourseLevel $courseLevel)
    {
        return view('courseLevel.edit', compact('courseLevel'));
    }

    public function update(Request $request, CourseLevel $courseLevel)
    {
        $validatedData = $request->validate([
            'course_level' => [
                'required', 'string', 'min:3', 'max:225', 'regex:/^[A-Za-z\s]+$/',
                Rule::unique('course_levels')->ignore($courseLevel->id)
            ],
        ]);

        $courseLevel->update($validatedData);

        return redirect(route('courseLevels.show', $courseLevel->id));
    }

}
