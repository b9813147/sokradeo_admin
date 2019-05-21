<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbaHistory extends Model
{
    public $timestamps = false;
    
    protected $dates = ['updated_at'];
    
    //
    protected $fillable = [
            'user_id', 'tba_id', 'updated_at',
    ];
    
    //
    public function tba()
    {
        return $this->belongsTo('App\Models\Tba');
    }
}
