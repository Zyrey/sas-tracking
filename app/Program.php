<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $attributes = [
        'type' => 1,
    ];


    public function getTypeAttribute($attribute)
    {
        return [
            1 => 'Masters',
            2 => 'Doctorate',
        ][$attribute];
    }


    public function cluster()
    {
        return $this->belongsTo(Cluster::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

}
