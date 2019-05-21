<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['resource_id', 'name', 'ext'];

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
