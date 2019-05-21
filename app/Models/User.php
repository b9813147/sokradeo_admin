<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'habook',
        'client_id',
        'client_user',
        'email',
        'thumbnail'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'client_user',
        'client_id',
        'remember_token',

    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function tbas()
    {
        return $this->hasMany(Tba::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class)->withPivot('member_status', 'member_duty')->withTimestamps();
    }
}
