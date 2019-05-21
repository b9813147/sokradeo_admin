<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupChannelContent extends Model
{
    protected $fillable = [
        'group_id',
        'group_channel_id',
        'content_id',
        'content_type',
        'content_status',
        'content_public'
    ];

    public function content()
    {
        return $this->morphTo('content');
    }
}
