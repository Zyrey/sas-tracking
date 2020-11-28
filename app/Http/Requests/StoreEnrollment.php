<?php

namespace App\Http\Requests;

use App\Course;
use App\Program;
use App\Student;
use Illuminate\Foundation\Http\FormRequest;

class StoreEnrollment extends FormRequest
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
            'student_id_number' => 'required|exists:students,id_number,status,1',
            'program_id' => [
                'bail', 'required', 'exists:programs,id',
                // Prevent enrolling student in a wrong program
                function ($attribute, $value, $fail) {
                    $student = Student::find($this->input('student_id_number'));
                    if (isset($student)) {
                        $programIds = Program::whereIn('cluster_id', $student->clusters->pluck('id')->toArray())->pluck('id')->toArray();
                        if (!in_array($value, $programIds)) {
                            $program = Program::find($value);
                            $fail($student->fullname.' is not registered in '. $program->cluster->cluster);
                        }
                    }
                }
            ],
            'courses' => 'required',
            'courses.*' => [
                'bail', 'exists:courses,id',
                // Prevent enrolling student in a course that does not belong to the selected program
                function ($attribute, $value, $fail) {
                    $program = Program::find($this->input('program_id'));
                    if (isset($program)) {
                        $programCourseIds = $program->courses->pluck('id')->toArray();
                        if (!in_array($value, $programCourseIds)) {
                            $course = Course::find($value);
                            $fail($course->course_number.' does not belong to the selected program.');
                        }
                    }
                }
            ]
        ];
    }
}
