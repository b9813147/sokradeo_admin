<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tba extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'thumbnail',
        'hits',
        'playlisted',
        'created_at',
        'updated_at',
        'teacher',
        'subject_field_id',
        'subject',
        'educational_stage_id',
        'grade',
        'lecture_type',
        'lecture_date',
        'locale_id',
        'mark',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //
    public function tags()
    {
        return $this->morphToMany('App\Models\Tag', 'taggable');
    }

    //
    public function tbaPlaylistTracks()
    {
        return $this->hasMany('App\Models\TbaPlaylistTrack');
    }

    //
    public function tbaAnalysisEvents()
    {
        return $this->hasMany('App\Models\TbaAnalysisEvent');
    }

    //
    public function tbaEvaluateUsers()
    {
        return $this->hasMany('App\Models\TbaEvaluateUser');
    }

    //
    public function tbaEvaluateEvents()
    {
        return $this->hasMany('App\Models\TbaEvaluateEvent');
    }

    //
    public function tbaStatistics()
    {
        return $this->hasMany('App\Models\TbaStatistic');
    }

    //
    public function tbaFeatures()
    {
        return $this->belongsToMany('App\Models\TbaFeature')->withTimestamps();
    }

    //
    public function tbaAnnexs()
    {
        return $this->hasMany('App\Models\TbaAnnex');
    }

    //
    public function subjectField()
    {
        return $this->belongsTo('App\Models\SubjectField');
    }

    //
    public function educationalStage()
    {
        return $this->belongsTo('App\Models\EducationalStage');
    }

    //
    public function locale()
    {
        return $this->belongsTo('App\Models\Locale');
    }

    //
    public function videos()
    {
        return $this->belongsToMany('App\Models\Video')->withPivot('tbavideo_order')->withTimestamps();
    }

    //
    public function tbaVideoMaps()
    {
        return $this->hasMany('App\Models\TbaVideoMap');
    }

    //
    public function groupChannels()
    {
        return $this->morphToMany('App\Models\GroupChannel', 'content', 'group_channel_contents')->withPivot('content_status', 'content_public')->withTimestamps();
    }
}
