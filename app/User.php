<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        if ($this->is_admin) {
            return true;
        }

        return false;
    }


    // Accessor
    public function getFullNameAttribute()
    {
        return ucwords("{$this->first_name} {$this->middle_name[0]}. {$this->last_name}");
    }


    public function getStatusAttribute($attribute)
    {
        return [
            0 => 'Inactive',
            1 => 'Active',
        ][$attribute];
    }


    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    public function cluster()
    {
        return $this->belongsTo(Cluster::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
