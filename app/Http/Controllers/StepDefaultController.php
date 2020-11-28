<?php

namespace App\Http\Controllers;

use App\EnrolledCourse;
use App\Enrollment;
use App\Form;
use App\StepDefault;
use App\Student;
use App\Tracking;
use App\TrackingStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StepDefaultController extends Controller
{
    public function create(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepDefault $stepDefault)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        return view('step-default.create', compact('student', 'enrollment', 'enrolledCourse', 'tracking', 'trackingStep', 'stepDefault'));
    }


    public function store(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, Request $request)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        $request->validate([
            'forms' => 'required',
            'forms.*' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5000',
            'remarks' => 'nullable|string|min:3,max:225',
        ]);

        $stepDefault = $trackingStep->stepDefault()->create($request->only('remarks'));

        foreach ($request->file('forms') as $form) {
            $this->uploadForm($form, $stepDefault);
        }

        return redirect(route('trackingSteps.show', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep]));
    }


    public function edit(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepDefault $stepDefault)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        return view('step-default.edit', compact('student', 'enrollment', 'enrolledCourse', 'tracking', 'trackingStep', 'stepDefault'));
    }


    public function update(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepDefault $stepDefault, Request $request)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        $request->validate([
            'forms' => 'nullable',
            'forms.*' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5000',
            'remarks' => 'nullable|string|min:3,max:225',
        ]);

        $stepDefault->update($request->only('remarks'));

        if ($request->hasFile('forms')) {
            foreach ($request->file('forms') as $form) {
                $this->uploadForm($form, $stepDefault);
            }
        }

        return redirect(route('trackingSteps.show', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id]));
    }


    public function deleteForm(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepDefault $stepDefault, Form $form)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        // Delete from public storage
        Storage::delete('public/' . $form->filename);
        // Delete from database
        $form->delete();

        return back()->with('message', "$form->title has been deleted successfully.");
    }


    private function uploadForm($form, $stepDefault)
    {
        // Create filename,
        $original = $form->getClientOriginalName();
        $filename = time() . '.' . uniqid() . '.' . $original;

        $stepDefault->forms()->create([
            'title' => $original,
            'filename' => $form->storeAs('upload/form', $filename, 'public'),
        ]);
    }


    private function validateAction($enrolledCourse, $tracking, $trackingStep)
    {
        // If not in current semester, updating enrolled course details is forbidden
        if (!$enrolledCourse->semester->isCurrent()) {
            abort(403, 'Action is forbidden. You are not in the current semester.');
        }

        // Prevent access if the enrollment status is not set as enrolled or incomplete.
        if (!$enrolledCourse->isEditable()) {
            abort(403, 'Action is Forbidden. Only enrolled and incomplete courses can be edited.');
        }

        // Prevent access if tracking is inactive
        if (!$tracking->isActive()) {
            abort(403, 'This action is forbidden. Tracking is inactive.');
        }

        // Prevent access if trackingStep is inactive
        if (!$trackingStep->isActive()) {
            abort(403, 'This action is forbidden. Tracking Step is inactive.');
        }

        // Prevent access if trackingStep is completed
        if ($trackingStep->isCompleted()) {
            abort(403, 'This action is forbidden. Tracking Step is already completed.');
        }
    }


}
