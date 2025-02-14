<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushMessage extends Model
{
    protected $table = 'push_messages';

    protected $fillable = ['title', 'message', 'status', 'url', 'campaign_id', 'action_button_url', 'action_button_title'];

    protected $appends = ['sections_id'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            $obj->created_by = auth()->user()->id;
        });
    }

    public function sections()
    {
        return $this->belongsToMany(CategoryNomenclature::class, 'push_messages_sections', 'message_id', 'section_id');
    }

    public function getSectionsIdAttribute()
    {
        return $this->sections()->get()->pluck('id');
    }
}
