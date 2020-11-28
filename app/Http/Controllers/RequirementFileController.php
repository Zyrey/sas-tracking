<?php

namespace App\Http\Controllers;

use App\EnrolledCourse;
use App\Enrollment;
use App\Faculty;
use App\Form;
use App\Http\Requests\StoreFile;
use App\Http\Requests\UpdateFile;
use App\RequirementFaculty;
use App\RequirementFile;
use App\RequirementTopic;
use App\StepRequirement;
use App\Student;
use App\Tracking;
use App\TrackingStep;
use Illuminate\Support\Facades\Storage;

class RequirementFileController extends Controller
{
    public function create(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementFile $requirementFile)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);
        // Abort if the requirement has a current file
        if ($stepRequirement->hasCurrentFile()) {
            abort(403, "Action is forbidden. The student already have a current file.");
        }

        return view('stepRequirement.create', compact('student', 'enrollment', 'enrolledCourse', 'tracking', 'trackingStep', 'stepRequirement', 'requirementFile'));
    }

    public function store(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, StoreFile $request)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);
        // Abort if the requirement has a current file
        if ($stepRequirement->hasCurrentFile()) {
            abort(403, "Action is forbidden. The student already have a current file.");
        }

        // Upload File,
        $original = $request->file->getClientOriginalName();
        $filename = time() . '.' . uniqid() . '.' . $original;
        // Create File
        $requirementFile = $stepRequirement->requirementFiles()->create([
            'title' => $original,
            'filename' => $request->file->storeAs('upload/manuscript', $filename, 'public'),
            'remarks' => $request->remarks,
        ]);
        // Upload form
        $this->uploadForm($request, $requirementFile);

        return redirect(route('trackingSteps.show', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep]))
            ->with('message', 'File created successfully.');
    }


    public function edit(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementFile $requirementFile)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        return view('stepRequirement.edit', compact('student', 'enrollment', 'enrolledCourse', 'tracking', 'trackingStep', 'stepRequirement', 'requirementFile'));
    }


    public function update(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementFile $requirementFile, UpdateFile $request)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        // Check if request has file
        if ($request->hasFile('file')) {
            // Delete existing file in public storage
            if ($stepRequirement->requirementFile)
            {
                Storage::delete('public/' . $stepRequirement->requirementFile->filename);
            }
            // Create a unique filename for the submitted file
            $original = $request->file->getClientOriginalName();
            $filename = time() . '.' . uniqid() . '.' . $original;
            // Update Filename in the database then store the submitted file to the public storage
            $stepRequirement->requirementFiles()->update([
                'title' => $original,
                'filename' => $request->file->storeAs('upload/manuscript', $filename, 'public'),
                'remarks' => $request->remarks,
            ]);
        } else {
            $stepRequirement->requirementFiles()->update([
                'remarks' => $request->remarks,
            ]);
        }

        // upload forms
        $this->uploadForm($request, $requirementFile);

        return redirect(route('trackingSteps.show', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep]))
            ->with('message', 'File updated successfully.');
    }


    public function deleteForm(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementFile $requirementFile, Form $form)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        // Delete from public storage
        Storage::delete('public/' . $form->filename);
        // Delete from database
        $form->delete();

        return back()->with('message', "$form->title has been deleted successfully.");
    }


    public function deactivate(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementFile $requirementFile)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        $requirementFile->update([
            'current' => 0,
        ]);

        return back()->with('message', $requirementFile->title . ' has been removed.');
    }


    public function activate(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementFile $requirementFile)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        // Deactivate all current files first before activating this file
        RequirementFile::where('step_requirement_id', $stepRequirement->id)
            ->where('current', 1)
            ->update([
                'current' => 0
            ]);

        $requirementFile->update([
            'current' => 1,
        ]);

        return back()->with('message', $requirementFile->title . ' has been restored.');
    }


    private function uploadForm($request, $requirementFile)
    {
        // Check if request has forms
        if ($request->hasFile('forms')) {
            foreach ($request->forms as $form) {
                $original = $form->getClientOriginalName();
                $filename = time() . '.' . uniqid() . '.' . $original;

                $requirementFile->forms()->create([
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
