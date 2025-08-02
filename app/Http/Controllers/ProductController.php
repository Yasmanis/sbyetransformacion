<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Traits\FileSave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    use FileSave;

    public function index(Request $request)
    {
        if (auth()->user()->hasView('product')) {
            $repository = new ProductRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            $repository->orderBy($request->sortBy, $request->sortDirection);
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('product')) {
            $request->validate([
                'name' => ['required', 'unique:products'],
            ]);
            $repository = new ProductRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            if ($request->hasFile('image_path')) {
                $properties = $this->getPropertiesFromFile($request->file('image_path'), 'products');
                $data['image'] = $properties['path'];
            }
            $product = $repository->create($data);
            if (isset($request->categories_id)) {
                $product->categories()->attach($request->categories_id);
            }
            return redirect()->back()->with('success', 'producto adicionado correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('product')) {
            $request->validate([
                'name' => ['required', Rule::unique('products', 'name')->ignore($id)],
            ]);
            $repository = new ProductRepository();
            $old_file = null;
            $data = $request->only((new ($repository->model()))->getFillable());
            if ($request->hasFile('image_path')) {
                $properties = $this->getPropertiesFromFile($request->file('image_path'), 'products');
                $data['image'] = $properties['path'];
                $object = $repository->getById($id);
                $old_file = $object->image;
            }
            $product = $repository->updateById($id, $data);
            if (isset($request->categories_id)) {
                $product->categories()->sync($request->categories_id);
            } else {
                $product->categories()->detach();
            }
            if ($old_file) {
                Storage::delete('public/' . $old_file);
            }
            return redirect()->back()->with('success', 'producto modificado correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('product')) {
            $repository = new ProductRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? 'producto eliminado correctamente' : 'productos eliminados correctamente');
        }
        return $this->deny_access($request);
    }

    public function public(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('product')) {
            $repository = new ProductRepository();
            $object = Product::find($id);
            $object->public  = !$object->public;
            $object->save();
            return redirect()->back()->with('success', $object->public ? 'producto publicado correctamente' : 'se ha dejado de publicar el producto correctamente');
        }
        return $this->deny_access($request);
    }
}
