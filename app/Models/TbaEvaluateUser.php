<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbaEvaluateUser extends Model
{
    //
    protected $fillable = [
            'tba_id', 'user_id', 'identity',
    ];
    
    //
    public function tba()
    {
        return $this->belongsTo('App\Models\Tba');
    }
    
    //
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    //
    public function tbaEvaluateEvents()
    {
        return $this->hasMany('App\Models\TbaEvaluateEvent');
    }
    
}
