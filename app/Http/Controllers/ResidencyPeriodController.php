<?php

namespace App\Http\Controllers;

use App\Enrollment;
use App\ResidencyPeriod;
use App\Student;
use Illuminate\Http\Request;

class ResidencyPeriodController extends Controller
{
    public function create(Student $student, Enrollment $enrollment, ResidencyPeriod $residencyPeriod) {
        return view('residencyPeriod.create', compact('student', 'enrollment', 'residencyPeriod'));
    }

    public function store(Student $student, Enrollment $enrollment, Request $request)
    {
        $request->validate([
            'month_start' => 'required|integer|between:1,12',
            'year_start' => 'required|digits:4',
        ]);

        $enrollment->residencyPeriod()->create($request->all());

        return redirect(route('students.show', $student->id_number));
    }

    public function edit(Student $student, Enrollment $enrollment, ResidencyPeriod $residencyPeriod)
    {
        return view('residencyPeriod.edit', compact('student', 'enrollment', 'residencyPeriod'));
    }

    public function update(Student $student, Enrollment $enrollment, ResidencyPeriod $residencyPeriod, Request $request)
    {
        $request->validate([
            'month_start' => 'required|integer|between:1,12',
            'year_start' => 'required|digits:4',
        ]);

        $residencyPeriod->update($request->all());

        return redirect(route('students.show', $student->id_number));
    }
}
