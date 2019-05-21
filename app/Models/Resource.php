<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = ['user_id','src_type', 'name', 'status'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function file()
    {
        return $this->hasOne(File::class);
    }
}
