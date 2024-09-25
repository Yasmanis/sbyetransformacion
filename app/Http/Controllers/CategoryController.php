<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $repository = new CategoryRepository();
        if (isset($request->search)) {
            $search = json_decode($request->search);
            $repository->where($search->column, $search->condition, $search->query);
        }
        if (isset($request->sortBy)) {
            $repository->orderBy($request->sortBy, $request->sortDirection);
        }
        return $this->data_index($repository, $request);
    }
}
