<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostSchedule extends FormRequest
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
            'remarks' => 'nullable|string|min:3,max:225',
            'forms.*' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5000',
            'date' => 'required|date|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'required|string:min:3|max:191',
        ];
    }
}
