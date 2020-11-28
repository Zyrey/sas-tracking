<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostTopic extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            'topic' => 'required|string|min:3|max:225',
        ];
    }
}
