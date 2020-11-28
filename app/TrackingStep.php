<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TrackingStep extends Model
{
    protected $guarded = [];

    protected $attributes = [
        'complete' => 0,
        'status' => 1,
        'default' => 0,
    ];

    public function getCompleteAttribute($attribute)
    {
        return [
            0 => 'Incomplete',
            1 => 'Completed',
        ][$attribute];
    }

    public function getStatusAttribute($attribute)
    {
        return [
            0 => 'Inactive',
            1 => 'Active',
        ][$attribute];
    }

    public function getDefaultAttribute($attribute)
    {
        return [
            0 => 'Custom',
            1 => 'Default',
        ][$attribute];
    }

    public function dateFormat($date)
    {
        return Carbon::parse($date)->format('m-d-Y, h:i A');
    }

    public function isDefault()
    {
        return $this->default == 'Default';
    }

    public function isActive()
    {
        return $this->status == 'Active';
    }

    public function isCompleted()
    {
        return $this->complete == 'Completed';
    }

    /*
     * Relationships
     * */
    public function tracking()
    {
        return $this->belongsTo(Tracking::class);
    }

    public function stepRequirements()
    {
        return $this->hasMany(StepRequirement::class);
    }

    public function stepDefault()
    {
        return $this->hasOne(StepDefault::class);
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
}
