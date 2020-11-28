<?php

namespace App\Http\Requests;

use App\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateFaculty extends FormRequest
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
        // get the model from the route
        $faculty = $this->route()->faculty;

        return [
            'institution_id' => 'required|exists:institutions,id',
            'first_name' => 'required|string|max:225|regex:/^[^0-9]+$/',
            'middle_name' => 'required|string|max:225|regex:/^[^0-9]+$/',
            'last_name' => 'required|string|max:225|regex:/^[^0-9]+$/',
            'id_number' => [
                'required', 'digits:7',
                Rule::unique('faculties')->ignore($faculty->id),
            ],
            'email' => [
                'required', 'email', 'max:225',
                'unique:superadmins,email',
                'unique:users,email',
                'unique:students,email',
                Rule::unique('faculties')->ignore($faculty->id),
            ],
            'contact_number' => [
                'required', 'digits:11',
                'unique:users,contact_number',
                'unique:students,contact_number',
                Rule::unique('faculties')->ignore($faculty->id)
            ],
            'clusters' => 'required|array',
            'clusters.*' => 'exists:clusters,id',
            'courses' => 'required|array',
            'courses.*' => [
                'bail', 'exists:courses,id',
                function ($attribute, $value, $fail) {
                    $course = Course::find($value);
                    if (!(in_array($course->program->cluster_id, $this->clusters ))) {
                        $fail($course->course_number . ' does not belong to the selected cluster.');
                    }
                }
            ]
        ];
    }
}
