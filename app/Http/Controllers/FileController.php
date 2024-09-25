<?php

namespace App\Http\Controllers;

use App\Repositories\FileRepository;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index(Request $request)
    {
        $repository = new FileRepository();
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
