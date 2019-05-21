<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbaStatistic extends Model
{
    //
    protected $fillable = [
            'tba_id', 'type', 'freq', 'duration', 'idx',
    ];
    
    //
    public function tba()
    {
        return $this->belongsTo('App\Models\Tba');
    }
}
