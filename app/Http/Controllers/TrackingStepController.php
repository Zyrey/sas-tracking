<?php

namespace App\Http\Controllers;

use App\Comment;
use App\EnrolledCourse;
use App\Enrollment;
use App\Http\Requests\StoreComment;
use App\Http\Requests\StoreTrackingStep;
use App\Http\Requests\UpdateTrackingStep;
use App\RequirementFaculty;
use App\RequirementFile;
use App\RequirementResult;
use App\RequirementSchedule;
use App\RequirementTopic;
use App\Student;
use App\Tracking;
use App\TrackingStep;

class TrackingStepController extends Controller
{
    public function showCompleted(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking)
    {
        $tracking->load('trackingSteps');
        return view('trackingStep.completed', compact('student', 'enrollment', 'enrolledCourse', 'tracking'));
    }


    public function create(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep)
    {
        $this->validateAction($enrolledCourse, $tracking);

        return view('trackingStep.create', compact('student', 'enrollment', 'enrolledCourse', 'tracking', 'trackingStep'));
    }


    public  function store(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, StoreTrackingStep $request)
    {
        $this->validateAction($enrolledCourse, $tracking);

        // Create Tracking Step
        $trackingStep = $tracking->trackingSteps()->create($request->except('requirements'));

        if ($request->has('requirements')) {
            $trackingStep->stepRequirements()->createMany($request->requirements);
        }

        return redirect(route('trackings.show', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id]))
            ->with('message', $trackingStep->step_name . ' has been created successfully.');
    }


    public function show(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep)
    {
        $trackingStep->load('stepRequirements');

        return view('trackingStep.show', compact('student', 'enrollment', 'enrolledCourse', 'tracking', 'trackingStep'));
    }


    public function edit(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep)
    {
        $this->validateAction($enrolledCourse, $tracking);
        // Prevent this action for default steps
        if ($trackingStep->isDefault()) {
            abort(403, 'Action is forbidden. Default steps cannot be edited or deleted.');
        }

        return view('trackingStep.edit', compact('student', 'enrollment', 'enrolledCourse', 'tracking', 'trackingStep'));
    }


    public function update(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, UpdateTrackingStep $request)
    {
        $this->validateAction($enrolledCourse, $tracking);
        // Prevent this action for default steps
        if ($trackingStep->isDefault()) {
            abort(403, 'Action is forbidden. Default steps cannot be edited or deleted.');
        }

        // Update Tracking Step
        $trackingStep->update($request->except('requirements'));
        if ($request->has('requirements')) {
            foreach ($request->requirements as $requirement) {
                $trackingStep->stepRequirements()->updateOrCreate($requirement);
            }
        }

        return redirect(route('trackingSteps.show', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id]))
            ->with('message', $trackingStep->step_name . ' has been updated successfully.');
    }


    public function destroy(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep)
    {
        $this->validateAction($enrolledCourse, $tracking);
        // Prevent this action for default steps
        if ($trackingStep->isDefault()) {
            abort(403, 'Action is forbidden. Default steps cannot be edited or deleted.');
        }

        // Tracking Steps with contents cannot be deleted
        // Check all the requirements of the tracking step if it has a content
        if ($trackingStep->stepRequirements->count() > 0) {
            foreach ($trackingStep->stepRequirements as $stepRequirement) {
                // Get the relationship for each requirement
                $relationship = $stepRequirement->getRelationship();
                // Requirements with contents cannot be deleted
                if ($stepRequirement->$relationship()->exists()) {
                    return back()->with('error', 'Delete Failed! Steps with content cannot be deleted.');
                }
            }
        } elseif ($trackingStep->stepDefault()->exists()) {
            return back()->with('error', 'Delete Failed! Steps with content cannot be deleted.');
        }

        // Delete Step
        $trackingStep->delete();

        return redirect(route('trackings.show', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id]))
            ->with('message', $trackingStep->step_name . ' has been deleted successfully.');
    }


    public function complete(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep)
    {
        $this->validateAction($enrolledCourse, $tracking);

        // Update status as complete
        $trackingStep->update([
            'complete' => 1,
        ]);

        return back()->with('message', $trackingStep->step_name . ' has been marked as complete.');
    }


    public function incomplete(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep)
    {
        $this->validateAction($enrolledCourse, $tracking);

        // Update status as incomplete
        $trackingStep->update([
            'complete' => 0,
        ]);

        return back()->with('error', $trackingStep->step_name . ' has been marked as incomplete.');
    }


    public function deactivate(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep)
    {
        $this->validateAction($enrolledCourse, $tracking);

        // Deactivate Contents
        $requirements = $trackingStep->stepRequirements;
        foreach ($requirements as $requirement) {
            $this->deactivateContents($requirement);
        }

        // Deactivate Step
        $trackingStep->update([
            'status' => 0,
        ]);

        return back()->with('error', $trackingStep->step_name . ' has been deactivated.');
    }


    public function activate(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep)
    {
        $this->validateAction($enrolledCourse, $tracking);

        // Deactivate active duplicates of the step
        $this->deactivateDuplicates($tracking, $trackingStep);

        // Activate selected trackingStep
        $trackingStep->update([
            'status' => 1,
        ]);

        return back()->with('message', $trackingStep->step_name . ' has been activated.');
    }


    public function duplicate(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep)
    {
        $this->validateAction($enrolledCourse, $tracking);

        // Deactivate Contents
        $requirements = $trackingStep->stepRequirements;
        foreach ($requirements as $requirement) {
            $this->deactivateContents($requirement);
        }

        // Deactivate active duplicates of the step
        $this->deactivateDuplicates($tracking, $trackingStep);

        // Count Duplicates
        $duplicatesCount = TrackingStep::where('tracking_id', $tracking->id)
            ->where('step_number', $trackingStep->step_number)
            ->count();

        // Create new step
        $newTrackingStep = $tracking->trackingSteps()->create([
            'step_number' => $trackingStep->step_number,
            'step_name' => $trackingStep->step_name,
            'take_number' => $duplicatesCount + 1,
            'default' => $trackingStep->default,
        ]);


        // Create step requirements
        if ($trackingStep->stepRequirements->count() > 0) {
            foreach ($trackingStep->stepRequirements as $stepRequirement) {
                $newTrackingStep->stepRequirements()->create([
                    // Get original value, not from accessor
                    'requirement' => $stepRequirement->getAttributes()['requirement'],
                ]);

            }
        }

        return redirect(route('trackingSteps.show', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $newTrackingStep->id]))
            ->with('message', $trackingStep->step_name . ' has been duplicated successfully.');
    }


    public function storeComment(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StoreComment $request)
    {
        $this->validateAction($enrolledCourse, $tracking);

        $trackingStep->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        return back()->with('message', 'Comment Saved!');
    }


    public function deleteComment(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, Comment $comment)
    {
        $this->validateAction($enrolledCourse, $tracking);

        $comment->delete();
        return back()->with('message', 'Comment Deleted!');
    }


    private function deactivateContents($requirement)
    {
        switch ($requirement->requirement) {
            case 'Adviser':
            case 'Panel':
                RequirementFaculty::where('step_requirement_id', $requirement->id)
                    ->whereCurrent(1)->update([
                        'current' => 0,
                    ]);
                break;

            case 'File':
                RequirementFile::where('step_requirement_id', $requirement->id)
                    ->whereCurrent(1)->update([
                        'current' => 0,
                    ]);
                break;

            case 'Result':
                RequirementResult::where('step_requirement_id', $requirement->id)
                    ->whereCurrent(1)->update([
                        'current' => 0,
                    ]);
                break;

            case 'Schedule':
                RequirementSchedule::where('step_requirement_id', $requirement->id)
                    ->whereCurrent(1)->update([
                        'current' => 0,
                    ]);
                break;

            case 'Topic':
                RequirementTopic::where('step_requirement_id', $requirement->id)
                    ->whereCurrent(1)->update([
                        'current' => 0,
                    ]);
                break;
        }
    }

    private function deactivateDuplicates(Tracking $tracking, TrackingStep $trackingStep)
    {
        TrackingStep::where('tracking_id', $tracking->id)
            ->where('step_number', $trackingStep->step_number)
            ->whereStatus(1)
            ->update([
                'status' => 0,
            ]);
    }

    private function validateAction($enrolledCourse, $tracking)
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
    }

}
