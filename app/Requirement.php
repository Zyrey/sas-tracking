<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function getRequirementAttribute($attribute)
    {
        return [
            1 => 'Adviser',
            2 => 'File',
            3 => 'Panel',
            4 => 'Result',
            5 => 'Schedule',
            6 => 'Topic',
        ][$attribute];
    }
}
