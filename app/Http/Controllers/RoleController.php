<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $repository = new RoleRepository();
        if (isset($request->search)) {
            $search = json_decode($request->search);
            $repository->where($search->column, $search->condition, $search->query);
        }
        if (isset($request->sortBy)) {
            $repository->orderBy($request->sortBy, $request->sortDirection);
        }
        return $this->data_index($repository, $request);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:30', 'unique:roles'],
        ]);
        $repository = new RoleRepository();
        $role = $repository->create($request->only((new ($repository->model()))->getFillable()));
        if (isset($request->permissions)) {
            $role->permissions()->sync($request->permissions);
        }
        return redirect()->back()->with('success', 'rol adicionado correctamente');
    }
}