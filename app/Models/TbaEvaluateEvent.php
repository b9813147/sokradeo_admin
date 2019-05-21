<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbaEvaluateEvent extends Model
{
    //
    protected $fillable = [
            'tba_id', 'tba_evaluate_user_id', 'tba_evaluate_event_mode_id', 'user_id', 'group_id', 'time_point', 'text',
    ];
    
    //
    public function tba()
    {
        return $this->belongsTo('App\Models\Tba');
    }
    
    //
    public function tbaEvaluateUser()
    {
        return $this->belongsTo('App\Models\TbaEvaluateUser');
    }
    
    //
    public function tbaEvaluateEventMode()
    {
        return $this->belongsTo('App\Models\TbaEvaluateEventMode');
    }
    
    //
    public function tbaEvaluateEventFiles()
    {
        return $this->hasMany('App\Models\TbaEvaluateEventFile');
    }
}
