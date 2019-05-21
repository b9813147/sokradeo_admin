<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExhibitionGroupChannelSet extends Model
{
    //
    protected $fillable = [
            'group_channel_id', 'type', 'order',
    ];
}
