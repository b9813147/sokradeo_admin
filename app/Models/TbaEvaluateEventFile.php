<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbaEvaluateEventFile extends Model
{
    //
    protected $fillable = [
            'name', 'ext',
    ];
    
    //
    public function tbaEvaluateEvent()
    {
        return $this->belongsTo('App\Models\TbaEvaluateEvent');
    }
    
}
