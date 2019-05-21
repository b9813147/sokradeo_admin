<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'school_code',
        'name',
        'description',
        'thumbnail',
        'status',
        'public'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('member_status', 'member_duty')->withTimestamps();
    }

    public function channels()
    {
        return $this->hasMany(GroupChannel::class);
    }
}
