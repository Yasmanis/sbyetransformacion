<?php

namespace App\Http\Controllers;

use App\Repositories\ShoppingRepository;
use Illuminate\Http\Request;

class ShoppingController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('shopping')) {
            $repository = new ShoppingRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
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
