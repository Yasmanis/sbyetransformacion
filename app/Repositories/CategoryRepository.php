<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends BaseRepository
{
    protected $with = ['files'];
    public function model()
    {
        return Category::class;
    }

    public function component()
    {
        return 'categories/list';
    }
}
