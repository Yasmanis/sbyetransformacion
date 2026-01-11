<?php

namespace App\Http\Controllers;

use App\Models\ProductSubcategory;
use App\Models\Subtitle;
use App\Repositories\ProductSubcategoryRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            $data = $request->only((new ($repository->model()))->getFillable());
            if ($request->hasFile('black_image')) {
                $path = $request->black_image->store('products', 'public');
                $data['black_image'] = $path;
            }
            if ($request->hasFile('white_image')) {
                $path = $request->white_image->store('products', 'public');
                $data['white_image'] = $path;
            }
            $object = $repository->create($data);
            if (isset($request->subtitles)) {
                $subtitles = [];
                $date = Carbon::now();
                foreach ($request->subtitles as $item) {
                    $subtitles[] = [
                        'name' => $item['name'],
                        'description' => $item['description'],
                        'subtitlable_type' => ProductSubcategory::class,
                        'subtitlable_id' => $object->id,
                        'created_at' => $date,
                        'updated_at' => $date,
                    ];
                }
                if (count($subtitles) > 0) {
                    Subtitle::insert($subtitles);
                }
            }
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
            $data = $request->only((new ($repository->model()))->getFillable());
            $current_black_image = null;
            if ($request->hasFile('black_image')) {
                $path = $request->black_image->store('products', 'public');
                $data['black_image'] = $path;
                $object = $repository->getById($id);
                if (isset($object->black_image)) {
                    $current_black_image = $object->black_image;
                }
            } else if (!isset($request->black_image)) {
                $object = $repository->getById($id);
                if (isset($object->black_image)) {
                    $current_black_image = $object->black_image;
                }
            }
            $current_white_image = null;
            if ($request->hasFile('white_image')) {
                $path = $request->white_image->store('products', 'public');
                $data['white_image'] = $path;
                $object = $repository->getById($id);
                if (isset($object->white_image)) {
                    $current_white_image = $object->white_image;
                }
            } else if (!isset($request->white_image)) {
                $object = $repository->getById($id);
                if (isset($object->white_image)) {
                    $current_white_image = $object->white_image;
                }
            }
            $repository->updateById($id, $data);
            if (isset($current_black_image)) {
                Storage::delete('public/' . $current_black_image);
            }
            if (isset($current_white_image)) {
                Storage::delete('public/' . $current_white_image);
            }
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
