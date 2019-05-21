<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $fillable = [
            'name',
    ];
    
    //
    public function videos()
    {
        return $this->morphedByMany('App\Models\Video', 'taggable');
    }
    
    //
    public function tbas()
    {
        return $this->morphToMany('App\Models\Tba', 'taggable');
    }
}
