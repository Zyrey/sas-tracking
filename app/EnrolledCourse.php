<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EnrolledCourse extends Model
{
    protected $guarded = [];

    public function getEnrollmentStatusAttribute($attribute)
    {
        return [
            0 => 'Enrolled',
            1 => 'Incomplete',
            2 => 'Dropped',
            3 => 'Withdrawn',
            4 => 'Completed',
        ][$attribute];
    }

    public function getCourseStatusAttribute($attribute)
    {
        return [
            0 => 'Failed',
            1 => 'In Progress',
            2 => 'Passed',
        ][$attribute];
    }

    public function dateFormat($date)
    {
        return Carbon::parse($date)->format('m-d-Y, h:i A');
    }

    // Only courses with an enrollment status of 'Enrolled' or 'Incomplete' can be edited
    public function isEditable()
    {
        return $this->enrollment_status == 'Enrolled' or $this->enrollment_status == 'Incomplete';
    }

    // Check if the enrollment status is set as 'Completed'
    public function isCompleted()
    {
        return $this->enrollment_status == 'Completed';
    }

    /*
     * Relationships
     * */
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function trackings()
    {
        return $this->hasMany(Tracking::class);
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
}
