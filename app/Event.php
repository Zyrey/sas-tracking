<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    // Start Date Format
    public function getStartAttribute($value)
    {
        return date('Y-m-d H:i', strtotime($value));
    }

    // End Date Format
    public function getEndAttribute($value)
    {
        return date('Y-m-d H:i', strtotime($value));
    }
}
