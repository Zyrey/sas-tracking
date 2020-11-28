<?php

namespace App\Http\Controllers;

use App\EnrolledCourse;
use App\Enrollment;
use App\Faculty;
use App\Form;
use App\Http\Requests\StorePanel;
use App\Http\Requests\UpdatePanel;
use App\RequirementFaculty;
use App\RequirementTopic;
use App\StepRequirement;
use App\Student;
use App\Tracking;
use App\TrackingStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RequirementPanelController extends Controller
{
    public function create(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        // Get internal faculties for the enrolled course
        $internalFaculties = Faculty::internal($enrollment, $enrolledCourse)->get();
        // Get external faculties for the enrolled course
        $externalFaculties = Faculty::external($enrollment, $enrolledCourse)->get();

        return view('stepRequirement.create', compact('student', 'enrollment', 'enrolledCourse', 'tracking', 'trackingStep', 'stepRequirement', 'internalFaculties', 'externalFaculties'));
    }


    public function store(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, StorePanel $request)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        if ($request->has('faculties.internal'))
        {
            foreach ($request->input('faculties.internal') as $internalFacultyId)
            {
                $stepRequirement->requirementFaculties()->create([
                    'faculty_id' => $internalFacultyId,
                    'role' => 2,
                ]);
            }
        }

        if ($request->has('faculties.external'))
        {
            foreach ($request->input('faculties.external') as $externalFacultyId)
            {
                $stepRequirement->requirementFaculties()->create([
                    'faculty_id' => $externalFacultyId,
                    'role' => 2,
                ]);
            }
        }

        return redirect(route('trackingSteps.show', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep]))
            ->with('message', 'Assigned to a panel successfully!');
    }


    public function edit(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementFaculty $requirementPanel)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);
        // Abort if the panel is not current
        if (!$requirementPanel->isCurrent()) {
            abort(403, 'Edit on previous panel is forbidden.');
        }

        // Get panel type
        $facultyType = $requirementPanel->faculty->institution->type;

        // Dynamically assign the value of $faculties
        if ($facultyType == 'Internal') {
            $faculties = Faculty::internal($enrollment, $enrolledCourse)->get();
        } else {
            $faculties = Faculty::external($enrollment, $enrolledCourse)->get();
        }

        return view('stepRequirement.edit', compact('student', 'enrollment', 'enrolledCourse', 'tracking', 'trackingStep', 'stepRequirement', 'requirementPanel', 'faculties'));
    }


    public function update(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementFaculty $requirementPanel, UpdatePanel $request)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);
        // Abort if the panel is not current
        if (!$requirementPanel->isCurrent()) {
            abort(403, 'Edit on previous panel is forbidden.');
        }

        // Update Panel
        $requirementPanel->update($request->except('forms'));
        // Assign requirementFaculties to $panel, will be used in uploading a form
        $panel = $requirementPanel;
        // upload forms
        $this->uploadForm($request, $panel);

        return redirect(route('trackingSteps.show', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep]))
            ->with('message', 'Panel has been updated successfully!');
    }


    public function deleteForm(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementFaculty $requirementPanel, Form $form)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        // Delete from public storage
        Storage::delete('public/' . $form->filename);
        // Delete from database
        $form->delete();

        return back()->with('message', "$form->title has been deleted successfully.");
    }


    public function deactivate(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementFaculty $requirementPanel)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        $requirementPanel->update([
            'current' => 0,
        ]);

        return back()->with('message', $requirementPanel->faculty->fullname . ' has been removed as your panel.');
    }


    public function activate(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, TrackingStep $trackingStep, StepRequirement $stepRequirement, RequirementFaculty $requirementPanel)
    {
        $this->validateAction($enrolledCourse, $tracking, $trackingStep);

        // Check if the faculty is the student's adviser
        $advisers = RequirementFaculty::whereHas('stepRequirement.trackingStep.tracking.enrolledCourse', function ($q) use($enrolledCourse) {
            return $q->whereId($enrolledCourse->id);
        })
            ->whereHas('stepRequirement.trackingStep.tracking', function ($q) {
                return $q->whereStatus(1);
            })
            ->whereHas('stepRequirement.trackingStep', function ($q) {
                return $q->whereStatus(1);
            })
            ->whereCurrent(1)->whereRole(1)->pluck('faculty_id')->toArray();

        if (in_array($requirementPanel->faculty_id, $advisers)) {
            return back()->with('error', $requirementPanel->faculty->fullname . ' is already the student\'s adviser.');
        }

        // Count the students handled by the requested faculties
        // Will be used to limit the number of students handled by the panel for every semester
        $countHandledStudents = EnrolledCourse::whereHas('trackings.trackingSteps.stepRequirements.requirementFaculties', function ($q) use ($requirementPanel){
            return $q->whereHas('stepRequirement.trackingStep.tracking', function ($q) use ($requirementPanel){
                return $q->whereStatus(1);
            })
                ->where('faculty_id', $requirementPanel->faculty_id)
                ->whereCurrent(1)
                ->whereRole(2);
        })
            ->where('semester_id', $enrolledCourse->semester_id)
            ->whereIn('enrollment_status', [0, 1]) // get only enrolled and completed
            ->count();
        if ($countHandledStudents >= 5) {
            $faculty = Faculty::find($requirementPanel->faculty_id);
            return back()->with('error', 'Restore Failed! '. $faculty->fullname . ' has already reached the maximum number of students for this semester');
        }


        if ($requirementPanel->faculty->institution->type == 'Internal') {
            // Count Internal Panels, will be used to limit the student's internal panel
            $internalPanels = RequirementFaculty::whereHas('stepRequirement.trackingStep.tracking.enrolledCourse', function ($q) use ($enrolledCourse) {
                return $q->whereId($enrolledCourse->id);
            })
                ->whereHas('stepRequirement.trackingStep.tracking', function ($q) {
                    return $q->whereStatus(1);
                })
                ->whereHas('stepRequirement.trackingStep', function ($q) {
                    return $q->whereStatus(1);
                })
                ->whereHas('faculty.institution', function ($q) {
                    return $q->where('type', 1);
                })
                ->whereRole(2)->whereCurrent(1)->count();

            if ($internalPanels > 3){
                return back()->with('error', 'Failed to restore .' . $requirementPanel->faculty->fullname . '. The student has reached the maximum number of internal panels.');
            }
        } else {
            // Count External Panels, will be used to limit the student's external panel
            $externalPanels = RequirementFaculty::whereHas('stepRequirement.trackingStep.tracking.enrolledCourse', function ($q) use ($enrolledCourse) {
                return $q->whereId($enrolledCourse->id);
            })
                ->whereHas('stepRequirement.trackingStep.tracking', function ($q) {
                    return $q->whereStatus(1);
                })
                ->whereHas('stepRequirement.trackingStep', function ($q) {
                    return $q->whereStatus(1);
                })
                ->whereHas('faculty.institution', function ($q) {
                    return $q->where('type', 2);
                })
                ->whereRole(2)->whereCurrent(1)->count();

            if ($externalPanels > 1){
                return back()->with('error', 'Failed to restore .' . $requirementPanel->faculty->fullname . '. The student has reached the maximum number of external panels.');
            }
        }

        $requirementPanel->update([
            'current' => 1,
        ]);

        return back()->with('message', $requirementPanel->faculty->fullname . ' has been restored as your current panel.');
    }


    private function uploadForm($request, $panel)
    {
        // Check if request has forms
        if ($request->hasFile('forms')) {
            foreach ($request->forms as $form) {
                $original = $form->getClientOriginalName();
                $filename = time() . '.' . uniqid() . '.' . $original;

                $panel->forms()->create([
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
