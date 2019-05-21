<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbaAnalysisEventMode extends Model
{
    //
    public function tbaAnalysisEvents()
    {
        return $this->hasMany('App\Models\TbaAnalysisEvent');
    }
}
