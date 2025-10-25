<?php

namespace App\Http\Controllers;

use App\Models\ProductSubcategory;
use App\Repositories\ProductSubcategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductSubcategoryController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('productsubcategory')) {
            $repository = new ProductSubcategoryRepository();
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
        if (auth()->user()->hasCreate('productsubcategory')) {
            $request->validate([
                'name' => [
                    'required',
                    Rule::unique('product_subcategory')->where('category_id', $request->category_id)
                ],
            ]);
            $repository = new ProductSubcategoryRepository();
            $repository->create($request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'subcategoria adicionada correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('productsubcategory')) {
            $request->validate([
                'name' => ['required', Rule::unique('product_subcategory')->where('category_id', $request->category_id)->ignore($id)],
            ]);
            $repository = new ProductSubcategoryRepository();
            $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'subcategoria modificada correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('productsubcategory')) {
            $repository = new ProductSubcategoryRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? 'subcategoria eliminada correctamente' : 'subcategorias eliminadas correctamente');
        }
        return $this->deny_access($request);
    }

    public function sort(Request $request)
    {
        if (auth()->user()->hasUpdate('productsubcategory')) {
            $objects = json_decode($request->ids);
            foreach ($objects as $c) {
                $obj = ProductSubcategory::find($c->id);
                if ($obj != null) {
                    $obj->order = $c->order;
                    $obj->save();
                }
            }
            return redirect()->back()->with('success', 'subcategorias ordenadas correctamente');
        }
        return $this->deny_access($request);
    }
}
