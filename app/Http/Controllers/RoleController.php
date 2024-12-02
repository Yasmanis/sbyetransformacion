<?php

namespace App\Http\Controllers;

use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('role')) {
            $repository = new RoleRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            $repository->orderBy($request->sortBy, $request->sortDirection);
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('role')) {
            $request->validate([
                'name' => ['required', 'unique:roles'],
            ]);
            $repository = new RoleRepository();
            $role = $repository->create($request->only((new ($repository->model()))->getFillable()));
            if (isset($request->permissions)) {
                $role->permissions()->sync($request->permissions);
            }
            return redirect()->back()->with('success', 'rol adicionado correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('role')) {
            $request->validate([
                'name' => ['required', Rule::unique('roles', 'name')->ignore($id)],
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
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('role')) {
            $repository = new RoleRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? 'rol eliminado correctamente' : 'roles eliminados correctamente');
        }
        return $this->deny_access($request);
    }
}
