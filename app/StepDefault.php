<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StepDefault extends Model
{
    protected $guarded = [];

    public function trackingStep()
    {
        return $this->belongsTo(TrackingStep::class);
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
