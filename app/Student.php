<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id_number';
    public $incrementing = false;

    protected $guarded = [];

    protected $attributes = [
        'status' => 1,
    ];


    public function getStatusAttribute($attribute)
    {
        return [
            1 => 'Active',
            0 => 'Inactive',
        ][$attribute];
    }


    public function isActive()
    {
        if ($this->status == 'Active') {
            return true;
        } else {
            return false;
        }
    }

    public function getFullNameAttribute()
    {
        return "{$this->last_name}, {$this->first_name}";
    }

    public function clusters()
    {
        return $this->belongsToMany(Cluster::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function residencyPeriod()
    {
        return $this->morphOne('App\ResidencyPeriod', 'residency_periodable');
    }



}
