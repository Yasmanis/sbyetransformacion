<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecycleBin extends Model
{
    use HasFactory;

    protected $table = 'recycle_bin';

    protected $fillable = [
        'recyclable_type',
        'recyclable_id',
        'title',
        'deleted_by',
        'auto_delete_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'auto_delete_at' => 'datetime',
    ];

    protected $appends = ['model', 'icon', 'type', 'user', 'deleted_at', 'permanent_deleted'];

    public function recyclable()
    {
        return $this->morphTo();
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function getModelAttribute()
    {
        $base_model = class_basename($this->recyclable_type);
        $module = Module::firstWhere('model', $base_model);
        if ($module) {
            return $module;
        }
        return [
            'singular_label' => $base_model,
            'ico' => 'mdi-trash'
        ];
    }

    public function getIconAttribute()
    {
        return $this->model->ico;
    }

    public function getTypeAttribute()
    {
        return $this->model->singular_label;
    }

    public function getUserAttribute()
    {
        return $this->deletedBy()->first()->full_name ?? '';
    }

    public function getDeletedAtAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }

    public function getPermanentDeletedAttribute()
    {
        return $this->auto_delete_at->format('d/m/Y');
    }

    public function scopeToAutoDelete($query)
    {
        return $query->where('auto_delete_at', '<=', now());
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('recyclable_type', 'App\\Models\\' . $type[0]);
    }
}
