<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $guarded = [];

    protected $attributes = [
        'status' => 1,
    ];

    public function getStatusAttribute($attribute)
    {
        return [
            0 => 'Inactive',
            1 => 'Active',
        ][$attribute];
    }

    public function getCompleteAttribute($attribute)
    {
        return [
            0 => 'Incomplete',
            1 => 'Completed',
        ][$attribute];
    }

    // Compute for the completion percentage for each tracking based on the completed steps
    public function getCompletionPercentage()
    {
        if ($this->trackingSteps()->whereStatus(1)->count() > 0) {
            return intval($this->trackingSteps()->whereStatus(1)->whereComplete(1)->count() * 100 /
                    $this->trackingSteps()->whereStatus(1)->count());
        } else {
            return 0;
        }

    }

    public function dateFormat($date)
    {
        return Carbon::parse($date)->format('m-d-Y, h:i A');
    }

    public function isActive()
    {
        return $this->status == 'Active';
    }

    public function hasCompletedStep()
    {
        return $this->trackingSteps()->whereStatus(1)->whereComplete(1)->count() > 0;
    }

    /*
     * Relationships
     * */
    public function enrolledCourse()
    {
        return $this->belongsTo(EnrolledCourse::class);
    }

    public function trackingSteps()
    {
        return $this->hasMany(TrackingStep::class);
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

}
