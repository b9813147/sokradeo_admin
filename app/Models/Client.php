<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\Models\ClientObserver;

class Client extends Model
{
    public    $incrementing = false;
    
    protected $keyType      = 'string';
    
    protected $fillable = [
            'type', 'name', 'secret',
    ];
    
    public static function boot()
    {
        parent::boot();
        self::observe(ClientObserver::class);
    }
}
