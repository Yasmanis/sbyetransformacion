<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\Subtitle;
use App\Repositories\ProductCategoryRepository;
use Carbon\Carbon;
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
        if (auth()->user()->hasCreate('productcategory')) {
            $request->validate([
                'name' => ['required', 'unique:product_category']
            ]);
            $repository = new ProductCategoryRepository();
            $object = $repository->create($request->only((new ($repository->model()))->getFillable()));
            if (isset($request->subtitles)) {
                $subtitles = [];
                $date = Carbon::now();
                foreach ($request->subtitles as $item) {
                    $subtitles[] = [
                        'name' => $item['name'],
                        'description' => $item['description'],
                        'subtitlable_type' => ProductCategory::class,
                        'subtitlable_id' => $object->id,
                        'created_at' => $date,
                        'updated_at' => $date,
                    ];
                }
                if (count($subtitles) > 0) {
                    Subtitle::insert($subtitles);
                }
            }
            return redirect()->back()->with('success', 'categoria adicionada correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('productcategory')) {
            $request->validate([
                'name' => ['required', Rule::unique('product_category', 'name')->ignore($id)],
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

    public function sort(Request $request)
    {
        if (auth()->user()->hasUpdate('productcategory')) {
            $objects = json_decode($request->ids);
            foreach ($objects as $c) {
                $obj = ProductCategory::find($c->id);
                if ($obj != null) {
                    $obj->order = $c->order;
                    $obj->save();
                }
            }
            return redirect()->back()->with('success', 'categorias ordenadas correctamente');
        }
        return $this->deny_access($request);
    }
}
