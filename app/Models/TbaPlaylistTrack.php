<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbaPlaylistTrack extends Model
{
    protected $fillable = [
            'tba_id', 'ref_tba_id', 'list_order', 'frag_name', 'frag_description', 'time_start', 'time_end',
    ];
}
