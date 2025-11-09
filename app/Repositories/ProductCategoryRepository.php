<?php

namespace App\Repositories;

use App\Models\ProductCategory;

class ProductCategoryRepository extends BaseRepository
{
    public function model()
    {
        return ProductCategory::class;
    }

    public function component()
    {
        return 'products/categories';
    }

    protected $with = ['subtitles'];
}
