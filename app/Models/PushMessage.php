<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Traits\DateUtils;

class PushMessage extends Model
{
    use DateUtils;
    protected $table = 'push_messages';

    protected $fillable = ['title', 'message', 'status', 'url', 'campaign_id', 'action_button_url', 'action_button_title', 'start_at', 'end_at', 'periodicity', 'image', 'video', 'logo'];

    protected $appends = ['sections_id', 'sections_str', 'campaign_str'];

    protected $casts = [
        'periodicity' => 'json'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            $obj->created_by = auth()->user()->id;
        });
        static::created(function ($obj) {
            $bi = BriefIdea::create([
                'message_id' => $obj->id,
                'title' => $obj->title,
                'message' => $obj->message,
            ]);
            if (request()->has('sections_id')) {
                $bi->sections()->attach(request('sections_id'));
            }
        });
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function sections()
    {
        return $this->belongsToMany(CategoryNomenclature::class, 'push_messages_sections', 'message_id', 'section_id');
    }

    public function getSectionsIdAttribute()
    {
        $sections = $this->sections()->get();
        return count($sections) > 0 ? $sections->pluck('id') : null;
    }

    public function getSectionsStrAttribute()
    {
        return $this->sections()->get()->implode('value', ', ');
    }

    public function getCampaignStrAttribute()
    {
        return $this->campaign->title;
    }

    public function getCreatedAtAttribute($v)
    {
        return Carbon::parse($v)->format('d/m/Y');
    }

    public function getNextAttribute($v)
    {
        return isset($v) ? Carbon::parse($v)->format('d/m/Y') : null;
    }

    public function getStartAtAttribute($v)
    {
        return isset($v) ? Carbon::parse($v)->format('d/m/Y h:i A') : null;
    }

    public function getEndAtAttribute($v)
    {
        return isset($v) ? Carbon::parse($v)->format('d/m/Y h:i A') : null;
    }
}