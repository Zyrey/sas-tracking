<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStep extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Only authenticated users can make this request
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
            'course_level_id' => 'required|exists:course_levels,id',
            // Step must be unique on each course_level
            'step' => [
                'required', 'string', 'min:3', 'max:225', 'regex:/^[A-Za-z\s]+$/',
                Rule::unique('steps')->where(function ($query) {
                    return $query->where('step', $this->input('step'))
                        ->where('course_level_id', $this->input('course_level_id'))
                        ->whereNotIn('id', [$this->route()->step->id]);
                })
            ],
            // Step number must be unique on each course_level
            'step_number' => [
                'required', 'integer', 'min:1', 'max:100',
                Rule::unique('steps')->where(function ($query) {
                    return $query->where('step_number', $this->input('step_number'))
                        ->where('course_level_id', $this->input('course_level_id'))
                        ->whereNotIn('id', [$this->route()->step->id]);
                })
            ],
            // optional
            'requirements' => 'sometimes|required|array',
            'requirements.*.requirement' => 'integer|between:1,6',
        ];
    }
}
