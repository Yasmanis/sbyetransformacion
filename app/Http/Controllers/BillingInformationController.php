<?php

namespace App\Http\Controllers;

use App\Repositories\BillingInformationRepository;
use Illuminate\Http\Request;

class BillingInformationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'address' => ['required'],
            'road' => ['required'],
            'province' => ['required'],
            'postal_code' => ['required'],
            'country_id' => ['required'],
        ]);
        $repository = new BillingInformationRepository();
        $object = $repository->create($request->only((new ($repository->model()))->getFillable()));
        return redirect()->back()->with([
            'success' => 'datos de facturacion adicionado correctamente',
            'object' => $object
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'address' => ['required'],
            'road' => ['required'],
            'province' => ['required'],
            'postal_code' => ['required'],
            'country_id' => ['required'],
        ]);
        $repository = new BillingInformationRepository();
        $data = $request->only((new ($repository->model()))->getFillable());
        $repository->updateById($id, $data);
        return redirect()->back()->with('success', 'datos de facturacion modificado correctamente');
    }

    public function destroy($ids)
    {
        $repository = new BillingInformationRepository();
        $ids = explode(',', $ids);
        if (count($ids) == 1) {
            $repository->deleteById($ids[0]);
        } else {
            $repository->deleteMultipleById($ids);
        }
        return redirect()->back()->with('success', count($ids) == 1 ? 'datos de facturacion eliminado correctamente' : 'datos de facturacion eliminados correctamente');
    }

    public function predetermined($id)
    {
        $repository = new BillingInformationRepository();
        $object = $repository->getById($id);
        $object->predetermined = !$object->predetermined;
        $object->save();
        return redirect()->back()->with('success', 'datos de facturacion establecido como predeterminado correctamente');
    }
}
