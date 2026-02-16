<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use App\Repositories\ShoppingRepository;
use Illuminate\Http\Request;

class ShoppingController extends Controller
{
    public function index(Request $request)
    {
        $repository = new ShoppingRepository();
        $repository->search($request->search);
        $repository->filters($request->filters);
        $categories = ProductCategory::whereHas(
            'subcategories',
            fn($subcategoryQuery) =>
            $subcategoryQuery->whereHas('products', fn($productQuery) => $productQuery->active())
        )->with([
            'subcategories' => fn($query) =>
            $query->whereHas('products', fn($productQuery) => $productQuery->active())
                ->orderBy('order', 'asc')
                ->with('subtitles'),
            'subcategories.products' => fn($query) =>
            $query->active()
                ->orderBy('order', 'asc')
                ->with('subtitles')
        ])
            ->orderBy('order', 'asc')
            ->with('subtitles')
            ->get();

        $subcategories = ProductSubcategory::whereHas('products', fn($productQuery) => $productQuery->active())
            ->orderBy('order', 'asc')
            ->get();
        return Inertia('store/index', [
            'categories' => $categories,
            'subcategories' => $subcategories
        ]);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('shopping')) {
            $repository = new ShoppingRepository();
            $repository->create($request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'compra adicionada correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('shopping')) {
            $repository = new ShoppingRepository();
            $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'compra modificada correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('shopping')) {
            $repository = new ShoppingRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? 'compra eliminada correctamente' : 'compras eliminadas correctamente');
        }
        return $this->deny_access($request);
    }
}
