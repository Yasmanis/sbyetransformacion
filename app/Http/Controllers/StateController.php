<?php

namespace App\Http\Controllers;

use App\Repositories\StateRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StateController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('state')) {
            $repository = new StateRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            $repository->orderBy($request->sortBy, $request->sortDirection);
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('state')) {
            $request->validate([
                'name' => ['required', 'unique:states'],
            ]);
            $repository = new StateRepository();
            $repository->create($request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'estado adicionado correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('state')) {
            $request->validate([
                'name' => ['required', Rule::unique('states', 'name')->ignore($id)],
            ]);
            $repository = new StateRepository();
            $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'estado modificado correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('state')) {
            $repository = new StateRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? 'estado eliminado correctamente' : 'estados eliminados correctamente');
        }
        return $this->deny_access($request);
    }
}