<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateStudent extends FormRequest
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
        $student = $this->route()->student;

        return [
            'first_name' => 'required|string|max:225|regex:/^[^0-9]+$/',
            'middle_name' => 'required|string|max:225|regex:/^[^0-9]+$/',
            'last_name' => 'required|string|max:225|regex:/^[^0-9]+$/',
            'id_number' => [
                'required', 'digits:7',
                Rule::unique('students')->ignore($student->id_number, 'id_number'),
            ],
            'email' => [
                'required', 'email', 'max:225',
                'unique:superadmins,email',
                'unique:users,email',
                'unique:faculties,email',
                Rule::unique('students')->ignore($student->id_number, 'id_number'),
            ],
            'contact_number' => [
                'required', 'digits:11',
                'unique:users,contact_number',
                'unique:faculties,contact_number',
                Rule::unique('students')->ignore($student->id_number, 'id_number'),
            ],
            'clusters' => 'required',
            'clusters.*.cluster_id' => 'required|exists:clusters,id',
        ];
    }
}
