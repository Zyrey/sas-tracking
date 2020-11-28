<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $attributes = [
        'type' => 2,
    ];


    public function getTypeAttribute($attribute)
    {
        return [
            1 => 'Internal',
            2 => 'External',
        ][$attribute];
    }

    public function faculties()
    {
        return $this->hasMany(Faculty::class);
    }
}
