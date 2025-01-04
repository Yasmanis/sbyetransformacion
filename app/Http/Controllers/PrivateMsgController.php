<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\File;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PrivateMsgController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('private_msg')) {
            $repository = new CategoryRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            $sortBy = $request->sortBy;
            $sortDirection = $request->sortDirection;
            if (!isset($sortBy)) {
                $sortBy = 'order';
                $sortDirection = 'ASC';
            }
            $repository->orderBy($sortBy, $sortDirection);
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('private_msg')) {
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
        if (auth()->user()->hasUpdate('private_msg')) {
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
        if (auth()->user()->hasDelete('private_msg')) {
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
        if (auth()->user()->hasUpdate('private_msg')) {
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

    public function sortCategories(Request $request)
    {
        if (auth()->user()->hasUpdate('private_msg')) {
            $categories = json_decode($request->ids);
            foreach ($categories as $c) {
                $category = Category::find($c->id);
                if ($category != null) {
                    $category->order = $c->order;
                    $category->save();
                }
            }
            return redirect()->back()->with('success', 'categorias ordenadas correctamente');
        }
        return $this->deny_access($request);
    }

    public function publicAccess(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('private_msg')) {
            $category = Category::find($id);
            $category->public_access = !$category->public_access;
            $category->save();
            return redirect()->back()->with('success', $category->public_access ? 'se ha pasado la categoria al acceso publico correctamente' : 'se ha quitado la categoria del acceso publico correctamente');
        }
        return $this->deny_access($request);
    }

    public function privateArea(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('private_msg')) {
            $category = Category::find($id);
            $category->private_area = !$category->private_area;
            $category->save();
            return redirect()->back()->with('success', $category->private_area ? 'se ha pasado la categoria al area privada correctamente' : 'se ha quitado la categoria del area privada correctamente');
        }
        return $this->deny_access($request);
    }
}