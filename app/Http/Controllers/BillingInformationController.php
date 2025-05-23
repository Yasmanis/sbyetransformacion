<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Repositories\BillingInformationRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BillingInformationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nif_cif' => ['required'],
            'road' => ['required'],
            'province' => ['required'],
            'postal_code' => ['required'],
            'country_id' => ['required'],
        ]);
        $repository = new BillingInformationRepository();
        $object = $repository->create($request->only((new ($repository->model()))->getFillable()));
        return redirect()->back()->with([
            'success' => 'dato de facturacion adicionado correctamente',
            'object' => $object
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
            'defeat' => ['required']
        ]);
        $repository = new BillingInformationRepository();
        $data = $request->only((new ($repository->model()))->getFillable());
        $repository->updateById($id, $data);
        return redirect()->back()->with('success', 'dato de facturacion modificado correctamente');
    }

    public function destroy(Request $request, $id)
    {
        $repository = new BillingInformationRepository();
        $repository->deleteById($id);
        return redirect()->back()->with('success', 'dato de facturacion eliminado correctamente');
    }

    public function predetermined(Request $request, $id)
    {
        $repository = new BillingInformationRepository();
        $object = $repository->getById($id);
        $object->predetermined = !$object->predetermined;
        $object->save();
        return redirect()->back()->with('success', 'dato de facturacion establecido como predeterminado correctamente');
    }
}
