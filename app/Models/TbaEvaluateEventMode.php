<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbaEvaluateEventMode extends Model
{
    //
    public function tbaEvaluateEvents()
    {
        return $this->hasMany('App\Models\TbaEvaluateEvent');
    }
}
