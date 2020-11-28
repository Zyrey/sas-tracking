<?php

namespace App\Http\Requests;

use App\EnrolledCourse;
use App\Faculty;
use App\RequirementFaculty;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePanel extends FormRequest
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
        // Get all active and inactive panels of the student for the specific course.
        // This faculties cannot be reselected as the student's panel
        // Previous advisers of the student can be selected as the student's panel
        $panels = RequirementFaculty::
        whereHas('stepRequirement.trackingStep.tracking.enrolledCourse', function ($q) {
            return $q->whereId($this->route()->enrolledCourse->id);
        })->whereHas('stepRequirement.trackingStep.tracking', function ($q) {
            return $q->whereStatus(1);
        })->whereHas('stepRequirement.trackingStep', function ($q) {
            return $q->whereStatus(1);
        })
            ->whereNotIn('id', [$this->route()->requirementPanel->id])
            ->whereRole(2)->get();

        // Get Current adviser, current adviser cannot be selected as the student's panel
        $currentAdviser = RequirementFaculty::whereHas('stepRequirement.trackingStep.tracking.enrolledCourse', function ($q) {
            return $q->whereId($this->route()->enrolledCourse->id);
        })->whereHas('stepRequirement.trackingStep.tracking', function ($q) {
            return $q->whereStatus(1);
        })->whereHas('stepRequirement.trackingStep', function ($q) {
            return $q->whereStatus(1);
        })
            ->whereRole(1)->whereCurrent(1)->pluck('faculty_id')->toArray();

        return [
            'remarks' => 'nullable|string|min:3,max:225',
            'forms.*' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5000',
            'faculty_id' => [
                'required', 'exists:faculties,id',
                // Unique faculty, selected adviser or panel cannot be duplicated
                function ($attribute, $value, $fail) use ($panels, $currentAdviser){
                    if (in_array($value, array_merge($panels->pluck('faculty_id')->toArray(), $currentAdviser))) {
                        $faculty = Faculty::find($value);
                        $fail($faculty->fullname . ' is already the student\'s faculty.');
                    }
                },
                // Check if adviser can handle the enrolled course
                function ($attribute, $value, $fail) {
                    $faculty = Faculty::find($value);
                    if (!in_array($this->route()->enrollment->program->cluster_id, $faculty->clusters->pluck('id')->toArray())) {
                        $fail($faculty->fullname . ' is not available for this cluster.');
                    } elseif (!in_array($this->route()->enrolledCourse->course_id, $faculty->courses->pluck('id')->toArray())) {
                        $fail($faculty->fullname . ' is not available for this course.');
                    }
                },
                // maximum of 5 students for each faculty in every semester
                function ($attribute, $value, $fail) {
                    $countAdvisingStudents = EnrolledCourse::whereHas('trackings.trackingSteps.stepRequirements.requirementFaculties', function ($query) use ($value){
                        return $query->whereNotIn('id', [$this->route()->requirementPanel->id])
                            ->whereHas('stepRequirement.trackingStep.tracking', function ($query) use ($value){
                                return $query->where('status', 1);
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
                        $fail($faculty->fullname . ' has already reached the maximum number of students for this semester.');
                    }
                },
            ],
        ];
    }
}
