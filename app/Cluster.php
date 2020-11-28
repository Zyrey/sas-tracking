<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function faculties()
    {
        return $this->belongsToMany(Faculty::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}
