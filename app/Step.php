<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function courseLevel()
    {
        return $this->belongsTo(CourseLevel::class);
    }

    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }
}
