<?php

namespace App\Http\Controllers;

use App\EnrolledCourse;
use App\Enrollment;
use App\Form;
use App\Http\Requests\PostTopic;
use App\RequirementTopic;
use App\StepRequirement;
use App\Student;
use App\Tracking;
use App\TrackingStep;
use Illuminate\Support\Facades\Storage;

class RequirementTopicController extends Controller
{
    public function create(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementTopic $requirementTopic)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);
        // Abort if the requirement has a current topic
        if ($stepRequirement->hasCurrentTopic()) {
            abort(403, "Action is forbidden. The student already have a current topic.");
        }

        return view('stepRequirement.create', compact('student', 'enrollment', 'enrolledCourse', 'tracking', 'trackingStep', 'stepRequirement', 'requirementTopic'));
    }

    public function store(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, PostTopic $request)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);
        // Abort if the requirement has a current topic
        if ($stepRequirement->hasCurrentTopic()) {
            abort(403, "Action is forbidden. The student already have a current topic.");
        }

        // Create topic
        $requirementTopic = $stepRequirement->requirementTopics()->create($request->except('forms'));
        // Upload form
        $this->uploadForm($request, $requirementTopic);
        return redirect(route('trackingSteps.show', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep]))
            ->with('message', 'Topic created successfully.');
    }


    public function edit(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementTopic $requirementTopic)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        return view('stepRequirement.edit', compact('student', 'enrollment', 'enrolledCourse', 'tracking', 'trackingStep', 'stepRequirement', 'requirementTopic'));
    }


    public function update(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementTopic $requirementTopic, PostTopic $request)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        // Update Topic
        $requirementTopic->update([
            'topic' => $request->topic,
            'remarks' => $request->remarks,
        ]);

        // Assign requirementTopic to $topic, will be used in uploading a form
        $topic = $requirementTopic;
        // upload forms
        $this->uploadForm($request, $requirementTopic);

        return redirect(route('trackingSteps.show', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep]))
            ->with('message', 'Topic updated successfully.');
    }


    public function deleteForm(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementTopic $requirementTopic, Form $form)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        // Delete from public storage
        Storage::delete('public/' . $form->filename);
        // Delete from database
        $form->delete();

        return back()->with('message', "$form->title has been deleted successfully.");
    }


    public function deactivate(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementTopic $requirementTopic)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        $requirementTopic->update([
            'current' => 0,
        ]);

        return back()->with('message', $requirementTopic->topic . ' has been removed.');
    }


    public function activate(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementTopic $requirementTopic)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        // Deactivate all current topics first before activating this topic
        RequirementTopic::where('step_requirement_id', $stepRequirement->id)
            ->where('current', 1)
            ->update([
                'current' => 0
            ]);

        $requirementTopic->update([
            'current' => 1,
        ]);

        return back()->with('message', $requirementTopic->topic . ' has been restored.');
    }


    private function uploadForm($request, $requirementTopic)
    {
        // Check if request has forms
        if ($request->hasFile('forms')) {
            foreach ($request->forms as $form) {
                $original = $form->getClientOriginalName();
                $filename = time() . '.' . uniqid() . '.' . $original;

                $requirementTopic->forms()->create([
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
