<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function getFullCourseAttribute()
    {
        return "{$this->course_number} - {$this->descriptive_title}";
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function courseLevel()
    {
        return $this->belongsTo(CourseLevel::class);
    }

    public function faculties()
    {
        return $this->belongsToMany(Faculty::class);
    }

    public function enrolledCourses()
    {
        return $this->hasMany(EnrolledCourse::class);
    }

}
