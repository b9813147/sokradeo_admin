<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbaVideoMap extends Model
{
    //
    protected $fillable = [
            'tba_id', 'video_id', 'tba_start', 'tba_end', 'video_offset',
    ];
    
}
