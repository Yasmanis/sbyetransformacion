<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $table = 'campaigns';
    protected $fillable = ['title', 'start_at', 'end_at', 'url', 'logo'];
    protected $appends = ['dir', 'assigned_to_id', 'sections', 'sections_id'];
    protected $guarded = ['id'];
    protected $casts = [
        'notes' => 'json'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            $obj->created_by = auth()->user()->id;
        });
    }

    // relations

    public function assignedTo()
    {
        return $this->belongsToMany(User::class, 'campaign_assigned_to', 'campaign_id', 'user_id')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sections()
    {
        return $this->belongsToMany(CategoryNomenclature::class, 'campaigns_sections', 'campaign_id', 'section_id');
    }

    // mutator
    public function getAssignedToAttribute()
    {
        return null;
        $dieticians = User::roleDietician()->orderBy('id', 'asc')->get()->pluck('id');
        $clients = User::roleUser()->orderBy('id', 'asc')->get()->pluck('id');
        $admins = User::roleAdmin()->orderBy('id', 'asc')->get()->pluck('id');
        $assigned = $this->assignedTo()->orderBy('id', 'asc')->get()->pluck('id');
        if (count($assigned) === User::count()) {
            return 'todos los usuarios';
        } elseif (count($assigned) === count($dieticians) && collect($assigned)->diff(collect($dieticians))->isEmpty()) {
            return 'dietista';
        } elseif (count($assigned) === count($clients) && collect($assigned)->diff(collect($clients))->isEmpty()) {
            return 'usuario';
        } elseif (count($assigned) === count($admins) && collect($assigned)->diff(collect($admins))->isEmpty()) {
            return 'admin';
        } else {
            return User::whereIn('id', $assigned)->pluck('name')->implode(', ');
        }
    }

    public function getAssignedToIdAttribute()
    {
        return $this->assignedTo()->get();
    }

    public function verificaSiEstaEsCampaignSection($value)
    {
        return null;
        $val = null;
        $campaignSections = CampaignSection::all()->pluck('id', 'name');
        foreach ($campaignSections as $key => $section) {
            if ($value == $key) {
                $val = $section;
            }
        }
        return $val;
    }



    // accessors

    public function getSectionsAttribute()
    {
        return $this->sections()->get()->implode('value', ', ');
    }

    public function getSectionsIdAttribute()
    {
        return $this->sections()->get()->pluck('id');
    }

    public function getStartAtAttribute($val)
    {
        return isset($val) ? Carbon::createFromFormat('Y-m-d H:i:s', $val)->format('d/m/Y h:i A') : null;
    }

    public function getEndAtAttribute($val)
    {
        return isset($val) ? Carbon::createFromFormat('Y-m-d H:i:s', $val)->format('d/m/Y h:i A') : null;
    }

    public function getCreatedByAttribute($val)
    {
        $user = User::find($val);
        return $user != null ? $user->full_name : null;
    }

    // scope

    public function scopefilterByRegex($query, $regex)
    {

        $section = $this->verificaSiEstaEsCampaignSection($regex);
        return $query
            ->where('campaign', 'like', '%' . $regex . '%')
            ->orWhere('section_id', 'like', '%' . $section . '%');
    }

    public function scopeFilterRole($query, $val)
    {
        return $query->whereHas('assignedTo', function ($query) use ($val) {
            $query->where('assigned_to', $val[0]);
        });
    }

    public function scopeFilterBySection($query, $val)
    {
        return $query->whereHas('sections', function ($query) use ($val) {
            $query->where('section_id', $val[0]);
        });
    }

    public function getDirAttribute()
    {
        return url('/admin/campaign');
    }

    public function getFilters()
    {
        return [
            [
                'label' => 'seccion',
                'scope' => 'filterBySection',
                'type' => 'select',
                'value' => null,
                'options' => Section::all('id as value', 'name as label')
            ],
            [
                'label' => 'alta',
                'field' => 'start_date',
                'type' => 'date',
                'value' => null,
            ],
            [
                'label' => 'fin',
                'field' => 'end_date',
                'type' => 'date',
                'value' => null,
            ],
            [
                'label' => 'rol',
                'scope' => 'filterRole',
                'type' => 'select',
                'value' => null,
                'options' => Role::all('id as value', 'name as label')
            ]
        ];
    }
}