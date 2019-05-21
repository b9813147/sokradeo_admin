<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbaAnalysisEvent extends Model
{
    //
    protected $fillable = [
            'tba_id', 'tba_analysis_event_mode_id', 'time_start', 'time_end', 'time_point',
    ];
    
    //
    public function tba()
    {
        return $this->belongsTo('App\Models\Tba');
    }
    
    //
    public function tbaAnalysisEventMode()
    {
        return $this->belongsTo('App\Models\TbaAnalysisEventMode');
    }
}
