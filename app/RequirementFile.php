<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RequirementFile extends Model
{
    protected $guarded = [];

    protected $attributes = [
        'current' => 1,
    ];

    public function getCurrentAttribute($attribute)
    {
        return [
            0 => 'Previous',
            1 => 'Current',
        ][$attribute];
    }


    public function isCurrent()
    {
        return $this->current == 'Current';

    }

    public function dateFormat($date)
    {
        return Carbon::parse($date)->format('m-d-Y, h:i A');
    }

    public function stepRequirement()
    {
        return $this->belongsTo(StepRequirement::class);
    }

    public function forms()
    {
        return $this->morphMany('App\Form', 'formable');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
}
