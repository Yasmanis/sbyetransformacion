<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('category')) {
            $repository = new CategoryRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            $repository->orderBy($request->sortBy, $request->sortDirection);
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('category')) {
            $request->validate([
                'name' => ['required', 'unique:category'],
            ]);
            $repository = new CategoryRepository();
            $repository->create($request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'categoria adicionado correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('category')) {
            $request->validate([
                'name' => ['required', Rule::unique('category', 'name')->ignore($id)],
            ]);
            $repository = new CategoryRepository();
            $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'categoria modificada correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('category')) {
            $repository = new CategoryRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? 'categoria eliminada correctamente' : 'categorias eliminadas correctamente');
        }
        return $this->deny_access($request);
    }

    public function sortFiles(Request $request)
    {
        if (auth()->user()->hasUpdate('category')) {
            $files = json_decode($request->ids);
            foreach ($files as $f) {
                $file = File::find($f->id);
                if ($file != null) {
                    $file->order = $f->order;
                    $file->save();
                }
            }
            return redirect()->back()->with('success', 'ficheros ordenados correctamente');
        }
        return $this->deny_access($request);
    }
}
