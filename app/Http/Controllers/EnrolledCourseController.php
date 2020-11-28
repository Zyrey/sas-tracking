<?php

namespace App\Http\Controllers;

use App\Comment;
use App\EnrolledCourse;
use App\Enrollment;
use App\Http\Requests\StoreComment;
use App\Http\Requests\UpdateEnrolledCourse;
use App\Student;
use Illuminate\Http\Request;

class EnrolledCourseController extends Controller
{
    // public function list(){
    //     $enrolledcourse = EnrolledCourse::orderBy('id', 'asc')->get();
    //     return $enrolledcourse;
    // }

    public function edit(Student $student, Enrollment $enrollment ,EnrolledCourse $enrolledCourse)
    {
        $this->validateAction($enrolledCourse);
        // Prevent access if the enrollment status is not set as completed.
        if (!$enrolledCourse->isCompleted()) {
            abort(403, 'Action is Forbidden. Enrolled course must be completed first.');
        }

        return view('student-enrolled-course.edit', compact('student', 'enrollment', 'enrolledCourse'));
    }

    public function deleteEnrolledCourse(Request $request){
        $course = EnrolledCourse::find($request['id']);
        $course->delete();
        return "DELETED!!!";
    }

    public function update(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, UpdateEnrolledCourse $request)
    {
        $this->validateAction($enrolledCourse);
        // Prevent access if the enrollment status is not set as completed.
        if (!$enrolledCourse->isCompleted()) {
            abort(403, 'Action is Forbidden. Enrolled course must be completed first.');
        }

        $enrolledCourse->update($request->except('comment'));

        if ($request->has('comment') and $request->comment != null) {
            $this->createComment($enrolledCourse, $request);
        }
        return redirect(route('trackings.index', [$student->id_number, $enrollment->id, $enrolledCourse->id]))
            ->with('message', 'Enrolled Course updated successfully.');
    }


    public function editEnrollmentStatus(Student $student, Enrollment $enrollment ,EnrolledCourse $enrolledCourse)
    {
        $this->validateAction($enrolledCourse);

        return view('student-enrolled-course.edit-enrollment-status', compact('student', 'enrollment', 'enrolledCourse'));
    }


    public function updateEnrollmentStatus(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, UpdateEnrolledCourse $request)
    {
        $this->validateAction($enrolledCourse);

        $enrolledCourse->update($request->except('comment'));

        if ($request->has('comment') and $request->comment != null) {
            $this->createComment($enrolledCourse, $request);
        }

        return redirect(route('trackings.index', [$student->id_number, $enrollment->id, $enrolledCourse->id]))
            ->with('message', 'Enrolled Course updated successfully.');
    }


    public function storeComment(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, StoreComment $request)
    {
        $this->validateAction($enrolledCourse);
        // Prevent access if the enrollment status is not set as enrolled or incomplete.
        if (!$enrolledCourse->isEditable()) {
            abort(403, 'Action is Forbidden. Only enrolled and incomplete courses can be edited.');
        }

        $this->createComment($enrolledCourse, $request);

        return back()->with('message', 'Comment Saved!');
    }


    public function deleteComment(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Comment $comment)
    {
        $this->validateAction($enrolledCourse);
        // Prevent access if the enrollment status is not set as enrolled or incomplete.
        if (!$enrolledCourse->isEditable()) {
            abort(403, 'Action is Forbidden. Only enrolled and incomplete courses can be edited.');
        }

        $comment->delete();
        return back()->with('message', 'Comment Deleted!');
    }


    private function createComment($enrolledCourse, $request)
    {
        $enrolledCourse->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);
    }


    private function validateAction($enrolledCourse)
    {
        // Check if user is authorized to update enrolled course details
        $this->authorize('update', $enrolledCourse);

        // If not in current semester, updating enrolled course details is forbidden
        if (!$enrolledCourse->semester->isCurrent()) {
            abort(403, 'Action is forbidden. You are not in the current semester.');
        }
    }
}
