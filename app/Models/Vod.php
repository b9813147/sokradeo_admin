<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vod extends Model
{
    //
    protected $fillable = [
            'resource_id', 'type', 'rid', 'rstatus',
    ];
    
    //
    public function resource()
    {
        return $this->belongsTo('App\Models\Resource');
    }
}
