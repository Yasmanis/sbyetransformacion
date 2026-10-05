<?php

namespace App\Models;

use App\Traits\Recyclable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicationSubcategory extends Model
{
    use HasFactory, Recyclable;

    protected $table = 'publication_subcategories';

    protected $fillable = ['name', 'category_id'];

    protected $appends = [
        'category_str',
    ];

    public function articles()
    {
        return $this->belongsToMany(File::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getCategoryStrAttribute()
    {
        return $this->category()->first()->name ?? '';
    }
}
