<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbaFavorite extends Model
{
    //
    protected $fillable = [
            'user_id', 'tba_id',
    ];
    
    //
    public function tba()
    {
        return $this->belongsTo('App\Models\Tba');
    }
}
