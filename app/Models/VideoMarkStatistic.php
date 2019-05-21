<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoMarkStatistic extends Model
{
    //
    protected $fillable = [
            'video_id', 'type', 'time', 'count',
    ];
    
    //
    public function video()
    {
        return $this->belongsTo('App\Models\Video');
    }
}
