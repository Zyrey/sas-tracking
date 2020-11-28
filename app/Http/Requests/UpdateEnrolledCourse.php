<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEnrolledCourse extends FormRequest
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
            'enrollment_status' => 'sometimes|required|integer|between:0,4',
            'course_status' => 'sometimes|required|integer|between:0,2',
            'grade' => 'sometimes|nullable|integer|between:65,99',
            'comment' => 'nullable|string|min:3,max:225',
        ];
    }
}
