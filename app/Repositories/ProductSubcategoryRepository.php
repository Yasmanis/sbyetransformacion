<?php

namespace App\Repositories;

use App\Models\ProductSubcategory;

class ProductSubcategoryRepository extends BaseRepository
{
    public function model()
    {
        return ProductSubcategory::class;
    }

    public function component()
    {
        return 'products/subcategories';
    }
}
