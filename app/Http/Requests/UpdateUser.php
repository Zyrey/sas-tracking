<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUser extends FormRequest
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
            'role_id' => 'sometimes|required|exists:roles,id',
            'cluster_id' => 'sometimes|required|exists:clusters,id',
            'first_name' => 'required|string|min:2,max:225|regex:/^[^0-9]+$/',
            'middle_name' => 'required|string|min:2,max:225|regex:/^[^0-9]+$/',
            'last_name' => 'required|string|min:2,max:225|regex:/^[^0-9]+$/',
            'email' => ['required', 'email', 'min:3' ,'max:225',
                'unique:superadmins,email',
                'unique:faculties,email',
                'unique:students,email',
                Rule::unique('users')->ignore($this->user->id)
            ],
            'contact_number' => [
                'required', 'digits:11',
                'unique:faculties,contact_number',
                'unique:students,contact_number',
                Rule::unique('users')->ignore($this->user->id),
            ],
        ];
    }
}
