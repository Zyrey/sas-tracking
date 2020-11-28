<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTrackingStep extends FormRequest
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
            'step_number' => [
                'required', 'integer', 'min:1', 'max:255',
                Rule::unique('tracking_steps')->where(function ($query) {
                    return $query->where('tracking_id', $this->route()->tracking->id)
                        ->where('step_number', $this->input('step_number'))
                        ->where('status', 1);
                })
            ],
            'step_name' => 'required',
            'requirements' => 'sometimes',
            'requirements.*.requirement' => 'integer|between:1,6',
        ];
    }
}
