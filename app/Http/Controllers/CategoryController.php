<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->sa || $user->hasAnyPermission(['view_category', 'update_category', 'delete_category', 'add_category'])) {
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
        return $this->deny_access();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:30', 'unique:category'],
        ]);
        $repository = new CategoryRepository();
        $repository->create($request->only((new ($repository->model()))->getFillable()));
        return redirect()->back()->with('success', 'categoria adicionado correctamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'max:30', Rule::unique('category', 'name')->ignore($id)],
        ]);
        $repository = new CategoryRepository();
        $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
        return redirect()->back()->with('success', 'categoria modificada correctamente');
    }
}
