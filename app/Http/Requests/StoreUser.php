<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Only superadmin can make this request
        if (Auth()->guard('superadmin')->check())
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
            'is_admin' => 'required|integer|between:0,1',
            'role_id' => 'sometimes|required|exists:roles,id',
            'cluster_id' => 'sometimes|required|exists:clusters,id',
            'first_name' => 'required|string|min:2,max:225|regex:/^[A-Za-z\s.,-]+$/',
            'middle_name' => 'required|string|min:2,max:225|regex:/^[A-Za-z\s.,-]+$/',
            'last_name' => 'required|string|min:2,max:225|regex:/^[A-Za-z\s.,-]+$/',
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
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
