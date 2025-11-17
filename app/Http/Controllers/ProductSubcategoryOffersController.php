<?php

namespace App\Http\Controllers;

use App\Models\ProductSubcategoryOffer;
use App\Repositories\ProductSubcategoryOfferRepository;
use App\Traits\FileSave;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductSubcategoryOffersController extends Controller
{
    use FileSave;

    public function index(Request $request, $id)
    {
        if (auth()->user()->hasView('productsubcategory')) {
            $repository = new ProductSubcategoryOfferRepository();
            $search = [
                'column' => 'subcategory_id',
                'condition' => '=',
                'query' => $id
            ];
            $repository->search(json_encode($search));
            $repository->filters($request->filters);
            $repository->orderBy($request->sortBy, $request->sortDirection);
            return response()->json($this->data_index_no_component($repository, $request));
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasUpdate('productsubcategory')) {
            $request->validate([
                'price' => ['required'],
                'start_at' => ['required'],
                'subcategory_id' => ['required'],
                'description' => ['required'],
            ]);
            $repository = new ProductSubcategoryOfferRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            $start_at = Carbon::createFromFormat('d/m/Y', $data['start_at'])->format('Y-m-d');
            try {
                $data['end_at'] = Carbon::createFromFormat('d/m/Y', $data['end_at'])->format('Y-m-d');
            } catch (\Throwable $th) {
                $data['end_at'] = null;
            }
            $data['start_at'] = $start_at;
            $object = $repository->create($data);
            return response()->json([
                'success' => true,
                'object' => $object,
                'message' => 'oferta adicionada correctamente'
            ]);
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('productsubcategory')) {
            $request->validate([
                'price' => ['required'],
                'start_at' => ['required'],
                'subcategory_id' => ['required'],
                'description' => ['required'],
            ]);
            $repository = new ProductSubcategoryOfferRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            $start_at = Carbon::createFromFormat('d/m/Y', $data['start_at'])->format('Y-m-d');
            try {
                $data['end_at'] = Carbon::createFromFormat('d/m/Y', $data['end_at'])->format('Y-m-d');
            } catch (\Throwable $th) {
                $data['end_at'] = null;
            }
            $data['start_at'] = $start_at;
            $object = $repository->updateById($id, $data);
            return response()->json([
                'success' => true,
                'object' => $object,
                'message' => 'oferta modificada correctamente'
            ]);
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasUpdate('productsubcategory')) {
            $repository = new ProductSubcategoryOfferRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return response()->json([
                'success' => true,
                'message' => count($ids) == 1 ? 'oferta eliminada correctamente' : 'ofertas eliminadas correctamente'
            ]);
        }
        return $this->deny_access($request);
    }

    public function active(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('product')) {
            $object = ProductSubcategoryOffer::find($id);
            $object->active  = !$object->active;
            $object->save();
            return response()->json([
                'success' => true,
                'object' => $object,
                'message' => $object->active ? 'oferta publicada correctamente' : 'oferta despublicada correctamente'
            ]);
        }
        return $this->deny_access($request);
    }
}
