<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RequirementFaculty extends Model
{
    protected $guarded = [];

    protected $attributes = [
        'current' => 1,
        'role' => 2,
    ];

    public function getCurrentAttribute($attribute)
    {
        return [
            0 => 'Previous',
            1 => 'Current',
        ][$attribute];
    }

    public function getRoleAttribute($attribute)
    {
        return [
            1 => 'Adviser',
            2 => 'Panel',
        ][$attribute];
    }


    public function isCurrent()
    {
        return $this->current == 'Current';
    }


    public function scopeActive($query, $trackingStep)
    {
        return $query->whereHas('stepRequirement.trackingStep', function ($query) use ($trackingStep) {
            return $query->where('id', $trackingStep->id);
        })
            ->where('current', 1);
    }


    public function scopeInactive($query, $trackingStep)
    {
        return $query->whereHas('stepRequirement.trackingStep', function ($query) use ($trackingStep) {
            return $query->where('id', $trackingStep->id);
        })
            ->where('current', 0);
    }


    public function dateFormat($date)
    {
        return Carbon::parse($date)->format('m-d-Y, h:i A');
    }


    public function stepRequirement()
    {
        return $this->belongsTo(StepRequirement::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
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
