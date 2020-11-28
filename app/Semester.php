<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $guarded = [];

    protected $attributes = [
        'term' => 1,
    ];

    public function getTermAttribute($attribute)
    {
        return [
            1 => 'First Semester',
            2 => 'Second Semester',
            3 => 'Short Term',
        ][$attribute];
    }


    public function getTermAndYearAttribute()
    {
        return "{$this->term}, {$this->year_start}-{$this->year_end}";
    }


    public function isCurrent()
    {
        return $this->current;
//        if ($this->current) {
//            return true;
//        } else {
//            return abort(403, 'Forbidden. Cannot create, update or delete if not in the current semester.');
//        }
    }


//    public function ifCurrent()
//    {
//        if ($this->current) {
//            return true;
//        } else {
//            return false;
//        }
//    }


    public function enrolledCourses()
    {
        return $this->hasMany(EnrolledCourse::class);
    }

}
