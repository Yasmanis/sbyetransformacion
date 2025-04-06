<?php

namespace App\Http\Controllers;

use App\Repositories\ReasonForReturnRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReasonForReturnController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('reasonrorreturn')) {
            $repository = new ReasonForReturnRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            $repository->orderBy($request->sortBy, $request->sortDirection);
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('reasonrorreturn')) {
            $request->validate([
                'name' => ['required', 'unique:reason_for_return'],
            ]);
            $repository = new ReasonForReturnRepository();
            $repository->create($request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'motivo adicionado correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('reasonrorreturn')) {
            $request->validate([
                'name' => ['required', Rule::unique('reason_for_return', 'name')->ignore($id)],
            ]);
            $repository = new ReasonForReturnRepository();
            $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'motivo modificado correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('reasonrorreturn')) {
            $repository = new ReasonForReturnRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? 'motivo eliminado correctamente' : 'motivos eliminados correctamente');
        }
        return $this->deny_access($request);
    }
}