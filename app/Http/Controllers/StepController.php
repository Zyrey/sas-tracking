<?php

namespace App\Http\Controllers;

use App\CourseLevel;
use App\Http\Requests\StoreStep;
use App\Http\Requests\UpdateStep;
use App\Requirement;
use App\Step;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StepController extends Controller
{
    public function index()
    {

        return view('step.index');
    }

    public function list(){
        $steps = Step::with('courseLevel')
            ->orderBy('course_level_id')
            ->orderBy('step_number')
            ->get();
            
        return $steps();
    }

    public function create(Step $step)
    {
        $courseLevels = CourseLevel::orderBy('course_level', 'asc')->get();

        return view('step.create', compact('step', 'courseLevels'));
    }

    public function store(StoreStep $request)
    {
        $step = Step::create($request->except('requirements'));

        if ($request->has('requirements')) {
            $step->requirements()->createMany($request->requirements);
        }

        return redirect(route('steps.show', $step->id));
    }


    public function show(Step $step)
    {
        return view('step.show', compact('step'));
    }


    public function edit(Step $step)
    {
        $courseLevels = CourseLevel::orderBy('course_level', 'asc')->get();

        return view('step.edit', compact('step', 'courseLevels'));
    }


    public function update(UpdateStep $request, Step $step)
    {
        $step->update($request->except('requirements'));

        if ($request->has('requirements'))
        {
            $step->requirements()->delete();
            $step->requirements()->createMany($request->requirements);
        }

        return redirect(route('steps.show', $step->id));
    }


    public function deleteRequirement(Step $step, Requirement $requirement)
    {
        $requirement->delete();
        return redirect()->back();
    }


}
