<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BriefIdea extends Model
{
    protected $table = 'brief_ideas';

    protected $fillable = ['title', 'message', 'message_id'];

    protected $appends = ['sections_str', 'start_at', 'end_at', 'image', 'video', 'periodicity', 'status', 'url', 'campaign_id', 'action_button_url', 'action_button_title', 'sections_id'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            $obj->created_by = auth()->user()->id;
        });
    }

    public function pushmessage()
    {
        return $this->belongsTo(PushMessage::class, 'message_id');
    }

    public function sections()
    {
        return $this->belongsToMany(CategoryNomenclature::class, 'briefideas_sections', 'briefidea_id', 'section_id');
    }

    public function getCreatedByAttribute($val)
    {
        $user = User::find($val);
        return $user != null ? $user->full_name : null;
    }

    public function getSectionsStrAttribute()
    {
        return $this->sections()->get()->implode('value', ', ');
    }

    public function getStartAtAttribute()
    {
        return $this->pushmessage->start_at;
    }

    public function getEndAtAttribute()
    {
        return $this->pushmessage->end_at;
    }

    public function getImageAttribute()
    {
        return $this->pushmessage->image;
    }

    public function getPeriodicityAttribute()
    {
        return $this->pushmessage->periodicity;
    }

    public function getStatusAttribute()
    {
        return $this->pushmessage->status;
    }

    public function getUrlAttribute()
    {
        return $this->pushmessage->url;
    }

    public function getCampaignIdAttribute()
    {
        return $this->pushmessage->campaign_id;
    }

    public function getActionButtonUrlAttribute()
    {
        return $this->pushmessage->action_button_url;
    }

    public function getActionButtonTitleAttribute()
    {
        return $this->pushmessage->action_button_title;
    }

    public function getVideoAttribute()
    {
        return $this->pushmessage->video;
    }

    public function getSectionsIdAttribute()
    {
        $sections = $this->sections;
        return count($sections) > 0 ? $sections->pluck('id') : null;
    }
}