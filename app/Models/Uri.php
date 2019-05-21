<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uri extends Model
{
    //
    protected $fillable = [
            'resource_id', 'url',
    ];
    
    //
    public function resource()
    {
        return $this->belongsTo('App\Models\Resource');
    }
}
