<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $attributes = [
        'status' => 1,
        'complete' => 0,
    ];

    public function getStatusAttribute($attribute)
    {
        return [
            0 => 'Inactive',
            1 => 'Active',
        ][$attribute];
    }


    public function getResidencyPeriod()
    {
        return Carbon::createFromDate($this->year_start, $this->month_start)->diff(\Carbon\Carbon::now())->format('%y years, %m months');
    }


    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function residencyPeriod()
    {
        return $this->morphOne('App\ResidencyPeriod', 'residency_periodable');
    }

    public function enrolledCourses()
    {
        return $this->hasMany(EnrolledCourse::class);
    }

}
