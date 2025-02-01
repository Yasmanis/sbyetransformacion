<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $table = 'campaigns';
    protected $fillable = ['title', 'start_date', 'end_date', 'url', 'logo'];
    protected $appends = ['dir', 'assigned_to', 'assigned_to_ids', 'sections', 'sections_id', 'start_date', 'end_date', 'note'];
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
        return $this->belongsToMany(User::class, 'campaign_assigned_tos', 'campaign_id', 'assigned_to')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'campaigns_sections', 'campaign_id', 'section_id');
    }

    // mutator
    public function getAssignedToAttribute()
    {
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

    public function getAssignedToIdsAttribute()
    {
        $ids = $this->assignedTo()->pluck('assigned_to')->toArray();
        return User::whereIn('id', $ids)->get();
    }

    public function verificaSiEstaEsCampaignSection($value)
    {
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
        return $this->sections()->get()->implode('name', ', ');
    }

    public function getSectionsIdAttribute()
    {
        return $this->sections()->get()->pluck('id');
    }

    public function getStartDateAttribute()
    {
        if (isset($this->attributes['start_date'])) {
            return DateTime::createFromFormat('Y-m-d', $this->attributes['start_date'])->format('d-m-Y');
        }
        return null;
    }

    public function getEndDateAttribute()
    {
        if (isset($this->attributes['end_date'])) {
            return DateTime::createFromFormat('Y-m-d', $this->attributes['end_date'])->format('d-m-Y');
        }
        return null;
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
