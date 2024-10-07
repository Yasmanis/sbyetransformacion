<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->sa || $user->hasAnyPermission(['view_role', 'update_role', 'delete_role', 'add_role'])) {
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
        return $this->deny_access();
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'max:30', Rule::unique('roles', 'name')->ignore($id)],
        ]);
        $repository = new RoleRepository();
        $role = $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
        if (isset($request->permissions)) {
            $role->permissions()->sync($request->permissions);
        } else {
            $role->permissions()->detach();
        }
        return redirect()->back()->with('success', 'rol modificado correctamente');
    }
}
