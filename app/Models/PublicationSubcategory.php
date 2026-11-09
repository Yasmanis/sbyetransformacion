<?php

namespace App\Models;

use App\Traits\Recyclable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PublicationSubcategory extends Model
{
    use HasFactory, Recyclable;

    protected $table = 'publication_subcategories';

    protected $fillable = ['name', 'category_id'];

    protected $appends = [
        'category_str',
        'families_str',
        'families_id'
    ];

    public function articles()
    {
        return $this->belongsToMany(File::class);
    }

    public function families(): BelongsToMany
    {
        return $this->belongsToMany(Family::class, 'family_subcategories', 'subcategory_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getCategoryStrAttribute()
    {
        return $this->category()->first()->name ?? '';
    }

    public function getFamiliesStrAttribute()
    {
        return $this->families()->pluck('name');
    }

    public function getFamiliesIdAttribute()
    {
        return $this->families()->pluck('id');
    }

    public function scopeWhereCategory($query, $val)
    {
        return $query->where('category_id', $val[0]);
    }

    public function scopeWhereFamily($query, $val)
    {
        return $query->whereHas('families', function ($q) use ($val) {
            $q->where('family_id', $val[0]);
        });
    }
}
