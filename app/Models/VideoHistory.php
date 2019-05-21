<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoHistory extends Model
{
    public $timestamps = false;
    
    protected $dates = ['updated_at'];
    
    //
    protected $fillable = [
            'user_id', 'video_id', 'updated_at',
    ];
    
    //
    public function video()
    {
        return $this->belongsTo('App\Models\Video');
    }
}
