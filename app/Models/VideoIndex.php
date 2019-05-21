<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoIndex extends Model
{
    //
    protected $fillable = [
            'video_id', 'name', 'time', 'thumbnail',
    ];
    
    //
    public function video()
    {
        return $this->belongsTo('App\Models\Video');
    }
}
