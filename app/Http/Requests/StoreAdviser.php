<?php

namespace App\Http\Requests;

use App\EnrolledCourse;
use App\Faculty;
use App\RequirementFaculty;
use Illuminate\Foundation\Http\FormRequest;

class StoreAdviser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Only authenticated user can make this request
        if (Auth()->check())
        {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Get all active and inactive advisers of the student for the specific course.
        // This faculties cannot be reselected as the student's adviser
        // Previous panels of the student can be selected as the student's adviser
        $advisers = RequirementFaculty::whereHas('stepRequirement.trackingStep.tracking.enrolledCourse', function ($q) {
            return $q->whereId($this->route()->enrolledCourse->id);
        })
            ->whereHas('stepRequirement.trackingStep.tracking', function ($q) {
                return $q->whereStatus(1);
            })
            ->whereHas('stepRequirement.trackingStep', function ($q) {
                return $q->whereStatus(1);
            })
            ->whereRole(1)->get();

        // Get Current adviser, current adviser cannot be selected as the student's panel
        $currentPanels = RequirementFaculty::whereHas('stepRequirement.trackingStep.tracking.enrolledCourse', function ($q) {
            return $q->whereId($this->route()->enrolledCourse->id);
        })
            ->whereHas('stepRequirement.trackingStep.tracking', function ($q) {
                return $q->whereStatus(1);
            })
            ->whereHas('stepRequirement.trackingStep', function ($q) {
                return $q->whereStatus(1);
            })
            ->whereRole(2)->whereCurrent(1)->pluck('faculty_id')->toArray();

        // Count current advisers, will be used to limit the student's adviser to 1
        $currentAdvisers = RequirementFaculty::whereHas('stepRequirement.trackingStep.tracking.enrolledCourse', function ($q) {
                return $q->whereId($this->route()->enrolledCourse->id);
            })
            ->whereHas('stepRequirement.trackingStep.tracking', function ($q) {
                return $q->whereStatus(1);
            })
            ->whereHas('stepRequirement.trackingStep', function ($q) {
                return $q->whereStatus(1);
            })
            ->whereRole(1)->whereCurrent(1)->count();

        return [
            'remarks' => 'nullable|string|min:3,max:225',
            'forms.*' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5000',
            'faculty_id' => [
                'required', 'exists:faculties,id',
                // Unique faculty, selected adviser or panel cannot be duplicated
                function ($attribute, $value, $fail) use ($advisers, $currentPanels){
                    if (in_array($value, array_merge($advisers->pluck('faculty_id')->toArray(), $currentPanels))) {
                        $faculty = Faculty::find($value);
                        $fail($faculty->fullname . ' is already the student\'s faculty.');
                    }
                },
                // Check if adviser can handle the enrolled course
                function ($attribute, $value, $fail) {
                    $faculty = Faculty::find($value);
                    if (isset($faculty)) {
                        if (!in_array($this->route()->enrollment->program->cluster_id, $faculty->clusters->pluck('id')->toArray())) {
                            $fail($faculty->fullname . ' is not available for this cluster.');
                        } elseif (!in_array($this->route()->enrolledCourse->course_id, $faculty->courses->pluck('id')->toArray())) {
                            $fail($faculty->fullname . ' is not available for this course.');
                        }
                    }
                },
                // Only one current adviser for each course
                function ($attribute, $value, $fail) use ($currentAdvisers) {
                    if ($currentAdvisers != 0) {
                        $fail('Can only have one current adviser for each course.');
                    }
                },
                // maximum of 5 students for each faculty in every semester
                function ($attribute, $value, $fail) {
                    $countAdvisingStudents = EnrolledCourse::whereHas('trackings.trackingSteps.stepRequirements.requirementFaculties', function ($q) use ($value){
                        return $q->whereHas('stepRequirement.trackingStep.tracking', function ($q) use ($value){
                            return $q->where('status', 1);
                        })
                            ->where('faculty_id', $value)
                            ->where('current', 1)
                            ->where('role', 1);
                    })
                        ->where('semester_id', $this->route()->enrolledCourse->semester_id)
                        ->whereIn('enrollment_status', [0, 1]) // get only enrolled and incomplete
                        ->count();
                    if ($countAdvisingStudents >= 5) {
                        $faculty = Faculty::find($value);
                        $fail('Failed to assign adviser. ' . $faculty->fullname . ' has already reached the maximum number of students for this semester');
                    }
                },

            ],
        ];
    }
}
