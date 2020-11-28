<?php

namespace App\Http\Controllers;

use App\EnrolledCourse;
use App\Enrollment;
use App\Faculty;
use App\Form;
use App\Http\Requests\StoreAdviser;
use App\Http\Requests\UpdateAdviser;
use App\Repositories\SemesterRepository;
use App\RequirementFaculty;
use App\RequirementTopic;
use App\StepRequirement;
use App\Student;
use App\Tracking;
use App\TrackingStep;
use Illuminate\Support\Facades\Storage;

class RequirementAdviserController extends Controller
{
    public function create(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementFaculty $requirementAdviser)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);
        // Abort if the requirement has a current adviser
        if ($stepRequirement->hasCurrentAdviser()) {
            abort(403, "Action is forbidden. The student already have a current adviser.");
        }
        // Get Active faculties
        $faculties = Faculty::active($enrollment, $enrolledCourse)->get();

        return view('stepRequirement.create', compact('student', 'enrollment', 'enrolledCourse', 'tracking', 'trackingStep', 'stepRequirement', 'requirementAdviser', 'faculties'));
    }


    public function store(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, StoreAdviser $request)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);
        // Abort if the requirement has a current adviser
        if ($stepRequirement->hasCurrentAdviser()) {
            abort(403, "Action is forbidden. The student already have a current adviser.");
        }

        // get the requested faculty, will be used for error messages
        $faculty = Faculty::find($request->faculty_id);
        // Create adviser
        $requirementAdviser = $stepRequirement->requirementFaculties()->create([
            'faculty_id' => $request->faculty_id,
            'role' => 1,
            'remarks' => $request->remarks,
        ]);
        // Upload forms
        $this->uploadForm($request, $requirementAdviser);

        return redirect(route('trackingSteps.show', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep]))
            ->with('message', $student->fullname . ' is assigned to ' . $faculty->fullname . ' successfully!');
    }


    public function edit(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementFaculty $requirementAdviser)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);
        // Abort if the adviser is not current
        if (!$requirementAdviser->isCurrent()) {
            abort(403, 'Action is forbidden. Only current adviser can be edited.');
        }

        // Get all the faculty that handles the course enrolled by the student
        $faculties = Faculty::active($enrollment, $enrolledCourse)->get();

        return view('stepRequirement.edit', compact('student', 'enrollment', 'enrolledCourse', 'tracking', 'trackingStep', 'stepRequirement', 'requirementAdviser', 'faculties'));
    }


    public function update(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementFaculty $requirementAdviser, UpdateAdviser $request)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);
        // Abort if the adviser is not current
        if (!$requirementAdviser->isCurrent()) {
            abort(403, 'Action is forbidden. Only current adviser can be edited.');
        }

        // Update Adviser
        $requirementAdviser->update($request->except('forms'));
        // upload forms
        $this->uploadForm($request, $requirementAdviser);

        return redirect(route('trackingSteps.show', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep]))
            ->with('message', 'Adviser updated successfully.');
    }


    public function deleteForm(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementFaculty $requirementAdviser, Form $form)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        // Delete from public storage
        Storage::delete('public/' . $form->filename);
        // Delete from database
        $form->delete();

        return back()->with('message', "$form->title has been deleted successfully.");
    }


    public function deactivate(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementFaculty $requirementAdviser)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        $requirementAdviser->update([
            'current' => 0,
        ]);

        return back()->with('message', $requirementAdviser->faculty->fullname . ' has been removed as your adviser.');
    }


    public function activate(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementFaculty $requirementAdviser)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        // Check if the faculty is the student's panel
        $panels = RequirementFaculty::whereHas('stepRequirement.trackingStep.tracking.enrolledCourse', function ($q) use($enrolledCourse) {
            return $q->whereId($enrolledCourse->id);
        })
            ->whereHas('stepRequirement.trackingStep.tracking', function ($q) {
                return $q->whereStatus(1);
            })
            ->whereHas('stepRequirement.trackingStep', function ($q) {
                return $q->whereStatus(1);
            })
            ->whereCurrent(1)->whereRole(2)->pluck('faculty_id')->toArray();

        if (in_array($requirementAdviser->faculty_id, $panels)) {
            return back()->with('error', $requirementAdviser->faculty->fullname . ' is already the student\'s panel.');
        }

        // Count the students handled by the requested faculties
        // Will be used to limit the number of students handled by the panel for every semester
        $countHandledStudents = EnrolledCourse::whereHas('trackings.trackingSteps.stepRequirements.requirementFaculties', function ($q) use ($requirementAdviser){
            return $q->whereHas('stepRequirement.trackingStep.tracking', function ($q) use ($requirementAdviser){
                return $q->whereStatus(1);
            })
                ->where('faculty_id', $requirementAdviser->faculty_id)
                ->whereCurrent(1)
                ->whereRole(1);
        })
            ->where('semester_id', $enrolledCourse->semester_id)
            ->whereIn('enrollment_status', [0, 1]) // get only enrolled and completed
            ->count();
        if ($countHandledStudents >= 5) {
            $faculty = Faculty::find($requirementAdviser->faculty_id);
            return back()->with('error', 'Restore Failed! '. $faculty->fullname . ' has already reached the maximum number of students for this semester');
        }

        // Deactivate all current advisers first before activating this adviser
        RequirementFaculty::where('step_requirement_id', $stepRequirement->id)
            ->where('role', 1)
            ->where('current', 1)
            ->update([
                'current' => 0
            ]);

        $requirementAdviser->update([
            'current' => 1,
        ]);

        return back()->with('message', $requirementAdviser->faculty->fullname . ' has been restored as your current adviser.');
    }


    private function uploadForm($request, $requirementAdviser)
    {
        // Check if request has forms
        if ($request->hasFile('forms')) {
            foreach ($request->forms as $form) {
                $original = $form->getClientOriginalName();
                $filename = time() . '.' . uniqid() . '.' . $original;

                $requirementAdviser->forms()->create([
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
