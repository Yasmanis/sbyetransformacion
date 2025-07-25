<?php

namespace App\Http\Controllers;

use App\Repositories\ProductCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('productcategory')) {
            $repository = new ProductCategoryRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            $repository->orderBy($request->sortBy, $request->sortDirection);
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('productcategory')) {
            $request->validate([
                'name' => ['required', 'unique:product_category']
            ]);
            $repository = new ProductCategoryRepository();
            $repository->create($request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'categoria adicionada correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('productcategory')) {
            $request->validate([
                'email' => ['required', Rule::unique('product_category', 'name')->ignore($id)],
            ]);
            $repository = new ProductCategoryRepository();
            $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'categoria modificada correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('productcategory')) {
            $repository = new ProductCategoryRepository();
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
}
