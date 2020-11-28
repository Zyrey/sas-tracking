<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $attributes = [
        'status' => 1,
    ];

    public function getStatusAttribute($attribute)
    {
        return [
            1 => 'Active',
            0 => 'Inactive',
        ][$attribute];
    }


    public function getFullNameAttribute()
    {
        return "{$this->last_name}, {$this->first_name}";
    }


    public function isActive()
    {
        if ($this->status == 'Active') {
            return true;
        } else {
            return false;
        }
    }


    public function scopeActive($query, $enrollment, $enrolledCourse)
    {
        return $query->whereHas('clusters', function ($query) use ($enrollment) {
            return $query->where('cluster_id', $enrollment->program->cluster_id);
        })
            ->whereHas('courses', function ($query) use ($enrolledCourse) {
                return $query->where('course_id', $enrolledCourse->course_id);
            })
            ->where('status', 1)
            ->orderBy('last_name');
    }


    public function scopeInternal($query, $enrollment, $enrolledCourse)
    {
        return $query->whereHas('clusters', function ($query) use ($enrollment) {
            return $query->where('cluster_id', $enrollment->program->cluster_id);
        })
            ->whereHas('courses', function ($query) use ($enrolledCourse) {
                return $query->where('course_id', $enrolledCourse->course_id);
            })
            ->whereHas('institution', function ($query) {
                return $query->where('type', 1);
            })
            ->where('status', 1)
            ->orderBy('last_name');
    }


    public function scopeExternal($query, $enrollment, $enrolledCourse)
    {
        return $query->whereHas('clusters', function ($query) use ($enrollment) {
            return $query->where('cluster_id', $enrollment->program->cluster_id);
        })
            ->whereHas('courses', function ($query) use ($enrolledCourse) {
                return $query->where('course_id', $enrolledCourse->course_id);
            })
            ->whereHas('institution', function ($query) {
                return $query->where('type', 2);
            })
            ->where('status', 1)
            ->orderBy('last_name');
    }


    public function clusters()
    {
        return $this->belongsToMany(Cluster::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function requirementFaculties()
    {
        return $this->hasMany(RequirementFaculty::class);
    }
}
