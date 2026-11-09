<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Family extends Model
{
    use HasFactory;

    protected $table = 'family';

    protected $fillable = ['name', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategories(): BelongsToMany
    {
        return $this->belongsToMany(PublicationSubcategory::class, 'family_subcategories', 'family_id', 'subcategory_id');
    }
}
