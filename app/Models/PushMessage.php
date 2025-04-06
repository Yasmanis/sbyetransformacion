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

    protected $appends = ['sections_id', 'sections_str', 'campaign_str', 'logo', 'is_fixed', 'notification_config'];

    protected $casts = [
        'periodicity' => 'json',
        'is_fixed' => 'boolean',
        'notification_config' => 'json'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            $obj->created_by = auth()->user()->id;
        });
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }

    public function fixed()
    {
        return $this->hasMany(PushMessageFixedUser::class, 'message_id');
    }

    public function config()
    {
        return $this->hasMany(PushMessageConfigNotification::class, 'message_id');
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

    public function getLogoAttribute()
    {
        return isset($this->campaign->logo) ? sprintf('storage/%s', $this->campaign->logo) : 'images/logo/1.png';
    }

    public function getIsFixedAttribute()
    {
        return $this->fixed()->where('user_id', auth()->user()->id)->first()->fixed ?? false;
    }

    public function getNotificationConfigAttribute()
    {
        return $this->config()->where('user_id', auth()->user()->id)->first()->data ?? null;
    }
}
