<?php

namespace App\Http\Controllers;

use App\Repositories\CountryRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('country')) {
            $repository = new CountryRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            $repository->orderBy($request->sortBy, $request->sortDirection);
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('country')) {
            $request->validate([
                'name' => ['required', 'unique:countries'],
            ]);
            $repository = new CountryRepository();
            $repository->create($request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'pais adicionado correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('country')) {
            $request->validate([
                'name' => ['required', Rule::unique('countries', 'name')->ignore($id)],
            ]);
            $repository = new CountryRepository();
            $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'pais modificado correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('country')) {
            $repository = new CountryRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? 'pais eliminado correctamente' : 'paises eliminados correctamente');
        }
        return $this->deny_access($request);
    }
}
