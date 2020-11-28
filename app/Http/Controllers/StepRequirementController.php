<?php

namespace App\Http\Controllers;

use App\EnrolledCourse;
use App\Enrollment;
use App\StepRequirement;
use App\Student;
use App\Tracking;
use App\TrackingStep;

class StepRequirementController extends Controller
{
    public function destroy(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        // Get the relationship for each requirement
        $relationship = $stepRequirement->getRelationship();
        // Requirements with contents cannot be deleted
        if ($stepRequirement->$relationship()->exists()) {
            return back()->with('error', 'Delete Failed! Requirements with content cannot be deleted.');
        }
        // Delete StepRequirement
        $stepRequirement->delete();
        return back()->with('message', $stepRequirement->requirement . ' has been deleted successfully.');
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

        // Default steps cannot be edited or deleted
        if ($trackingStep->isDefault()) {
            abort(403, 'Edit or delete on a default step is forbidden.');
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
