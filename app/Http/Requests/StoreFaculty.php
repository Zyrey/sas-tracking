<?php

namespace App\Http\Requests;

use App\Cluster;
use App\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreFaculty extends FormRequest
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
        return [
            'institution_id' => 'required|exists:institutions,id',
            'id_number' => 'required|digits:7|unique:faculties,id_number',
            'first_name' => 'required|string|max:225|regex:/^[A-Za-z\s.,-]+$/',
            'middle_name' => 'required|string|max:225|regex:/^[A-Za-z\s.,-]+$/',
            'last_name' => 'required|string|max:225|regex:/^[A-Za-z\s.,-]+$/',
            'email' => ['required', 'email', 'min:3' ,'max:225',
                'unique:superadmins,email',
                'unique:users,email',
                'unique:faculties,email',
                'unique:students,email',
            ],
            'contact_number' => [
                'required', 'digits:11',
                'unique:users,contact_number',
                'unique:faculties,contact_number',
                'unique:students,contact_number',
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
