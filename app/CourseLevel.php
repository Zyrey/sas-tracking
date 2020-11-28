<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseLevel extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function steps()
    {
        return $this->hasMany(Step::class);
    }
}
