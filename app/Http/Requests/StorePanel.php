<?php

namespace App\Http\Requests;

use App\EnrolledCourse;
use App\Faculty;
use App\RequirementFaculty;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePanel extends FormRequest
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

        // Count Internal Panels, will be used to limit the student's internal panel
        $internalPanels = RequirementFaculty::whereHas('stepRequirement.trackingStep.tracking.enrolledCourse', function ($q) {
            return $q->whereId($this->route()->enrolledCourse->id);
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

        // Count External Panels, will be used to limit the student's external panel
        $externalPanels = RequirementFaculty::whereHas('stepRequirement.trackingStep.tracking.enrolledCourse', function ($q) {
            return $q->whereId($this->route()->enrolledCourse->id);
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

        return [
            'remarks' => 'nullable|string|min:3,max:225',
            'forms.*' => 'nullable|file|image|mimes:jpeg,png,jpg|max:5000',
            'faculties.internal' => [
                // Internal faculty is required if the student's internal panel is less than 2
                Rule::requiredIf(function () use($internalPanels) {
                    return $internalPanels < 2;
                }),
                'array',
                // Maximum of 3 internal panels for each course
                function ($attribute, $value, $fail) use ($internalPanels) {
                    if ($internalPanels == 3) {
                        $fail('The student has reached the maximum number of Internal Panel.');
                    } elseif (($internalPanels + count($this->input('faculties.internal'))) > 3) {
                        $fail('The Internal Panel may not be more than ' . (3 - $internalPanels));
                    }
                }
            ],
            'faculties.external' => [
                // External faculty is required if the student's external panel is less than 1
                Rule::requiredIf(function () use($externalPanels) {
                    return $externalPanels < 1;
                }),
                'array', 'size:1',
                // Maximum of 2 external panels for each course
                function ($attribute, $value, $fail) use ($externalPanels) {
                    if ($externalPanels == 2) {
                        $fail('The student has reached the maximum number of External Panel.');
                    }
                }
            ],
            'faculties.*.*' => [
                'bail', 'exists:faculties,id', 'distinct',
                // Unique faculty, selected adviser or panel cannot be duplicated
                function ($attribute, $value, $fail) use ($panels, $currentAdviser){
                    if (in_array($value, array_merge($panels->pluck('faculty_id')->toArray(), $currentAdviser))) {
                        $faculty = Faculty::find($value);
                        $fail($faculty->fullname . ' is already the student\'s faculty.');
                    }
                },
                // Check if the panel can handle the enrolled course
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
                // Count the students handled by the requested faculties
                // Limit the number of students handled by the panel for every semester
                function ($attribute, $value, $fail) {
                    $countHandledStudents = EnrolledCourse::whereHas('trackings.trackingSteps.stepRequirements.requirementFaculties', function ($q) use ($value){
                        return $q->whereHas('stepRequirement.trackingStep.tracking', function ($q) use ($value){
                            return $q->whereStatus(1);
                        })
                            ->where('faculty_id', $value)
                            ->whereCurrent(1)
                            ->whereRole(2);
                    })
                        ->where('semester_id', $this->route()->enrolledCourse->semester_id)
                        ->whereIn('enrollment_status', [0, 1]) // get only enrolled and incomplete
                        ->count();
                    if ($countHandledStudents >= 5) {
                        $faculty = Faculty::find($value);
                        $fail($faculty->fullname . ' has already reached the maximum number of students for this semester');
                    }
                },
            ],

        ];
    }

    // Custom error message for selecting current faculties
    public function messages()
    {
        return [
            'faculties.internal.required' => 'The internal panel field is required.',
            'faculties.external.required' => 'The external panel field is required.',
        ];
    }
}
