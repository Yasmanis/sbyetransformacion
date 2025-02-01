<?php

namespace App\Http\Controllers;

use App\Repositories\SectionRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SectionsController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('categorynomenclature')) {
            $repository = new SectionRepository();
            $repository->search($request->search);
            $repository->orderBy($request->sortBy, $request->sortDirection);
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('categorynomenclature')) {
            $request->validate([
                'value' => ['required', 'unique:categories_nomenclatures'],
            ]);
            $repository = new SectionRepository();
            $role = $repository->create($request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'seccion adicionada correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('categorynomenclature')) {
            $request->validate([
                'value' => ['required', Rule::unique('categories_nomenclatures', 'value')->ignore($id)],
            ]);
            $repository = new SectionRepository();
            $role = $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'seccion modificada correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('categorynomenclature')) {
            $repository = new SectionRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? 'seccion eliminada correctamente' : 'secciones eliminadas correctamente');
        }
        return $this->deny_access($request);
    }
}