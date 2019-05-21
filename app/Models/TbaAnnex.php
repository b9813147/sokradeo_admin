<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbaAnnex extends Model
{
    protected $fillable = ['resource_id', 'type'];

    public function resources()
    {
        return $this->belongsTo(Resource::class);
    }
}
