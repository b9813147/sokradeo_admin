<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupChannel extends Model
{
    protected $fillable = [
        'group_id',
        'cms_type',
        'name',
        'description',
        'thumbnail',
        'status',
        'public'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function videos()
    {
        return $this->morphedByMany(Video::class,'content','group_channel_contents')->withPivot('content_status')->withTimestamps();
    }

    public function tbas()
    {
        return $this->morphedByMany(Tba::class,'content','group_channel_contents')->withPivot('content_status')->withTimestamps();
    }

}
