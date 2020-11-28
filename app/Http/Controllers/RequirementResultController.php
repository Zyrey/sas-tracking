<?php

namespace App\Http\Controllers;

use App\EnrolledCourse;
use App\Enrollment;
use App\Form;
use App\Http\Requests\PostResult;
use App\RequirementResult;
use App\RequirementTopic;
use App\StepRequirement;
use App\Student;
use App\Tracking;
use App\TrackingStep;
use Illuminate\Support\Facades\Storage;

class RequirementResultController extends Controller
{
    public function create(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementResult $requirementResult)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);
        // Abort if the requirement has a current result
        if ($stepRequirement->hasCurrentResult()) {
            abort(403, "Action is forbidden. The student already have a current result.");
        }

        return view('stepRequirement.create', compact('student', 'enrollment', 'enrolledCourse', 'tracking', 'trackingStep', 'stepRequirement', 'requirementResult'));
    }

    public function store(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, PostResult $request)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);
        // Abort if the requirement has a current result
        if ($stepRequirement->hasCurrentResult()) {
            abort(403, "Action is forbidden. The student already have a current result.");
        }
        // Create result
        $requirementResult = $stepRequirement->requirementResults()->create($request->except('forms'));
        // Upload form
        $this->uploadForm($request, $requirementResult);
        return redirect(route('trackingSteps.show', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep]))
            ->with('message', 'Result created successfully.');
    }


    public function edit(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementResult $requirementResult)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        return view('stepRequirement.edit', compact('student', 'enrollment', 'enrolledCourse', 'tracking', 'trackingStep', 'stepRequirement', 'requirementResult'));
    }


    public function update(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementResult $requirementResult, PostResult $request)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        // Update Topic
        $requirementResult->update($request->except('forms'));
        // upload forms
        $this->uploadForm($request, $requirementResult);

        return redirect(route('trackingSteps.show', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep]))
            ->with('message', 'Result updated successfully.');
    }


    public function deleteForm(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementResult $requirementResult, Form $form)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        // Delete from public storage
        Storage::delete('public/' . $form->filename);
        // Delete from database
        $form->delete();

        return back()->with('message', "$form->title has been deleted successfully.");
    }


    public function deactivate(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementResult $requirementResult)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        $requirementResult->update([
            'current' => 0,
        ]);

        return back()->with('message', 'Result has been removed.');
    }


    public function activate(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementResult $requirementResult)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        // Deactivate all current results first before activating this result
        RequirementResult::where('step_requirement_id', $stepRequirement->id)
            ->where('current', 1)
            ->update([
                'current' => 0
            ]);

        $requirementResult->update([
            'current' => 1,
        ]);

        return back()->with('message', 'Result has been restored.');
    }


    private function uploadForm($request, $requirementResult)
    {
        // Check if request has forms
        if ($request->hasFile('forms')) {
            foreach ($request->forms as $form) {
                $original = $form->getClientOriginalName();
                $filename = time() . '.' . uniqid() . '.' . $original;

                $requirementResult->forms()->create([
                    'title' => $original,
                    'filename' =>  $form->storeAs('upload/form', $filename, 'public'),
                ]);
            }
        }
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
