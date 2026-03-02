<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Repositories\PaymentMethodRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentMethodController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'number' => ['required', 'unique:users_payment_methods'],
            'defeat' => ['required'],
        ]);
        $repository = new PaymentMethodRepository();
        $repository->create($request->only((new ($repository->model()))->getFillable()));
        return redirect()->back()->with('success', 'metodo de pago adicionado correctamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
            'defeat' => ['required']
        ]);
        $repository = new PaymentMethodRepository();
        $data = $request->only((new ($repository->model()))->getFillable());
        $repository->updateById($id, $data);
        return redirect()->back()->with('success', 'metodo de pago modificado correctamente');
    }

    public function destroy($ids)
    {
        $repository = new PaymentMethodRepository();
        $ids = explode(',', $ids);
        if (count($ids) == 1) {
            $repository->deleteById($ids[0]);
        } else {
            $repository->deleteMultipleById($ids);
        }
        return redirect()->back()->with('success', count($ids) == 1 ? 'metodo de pago eliminado correctamente' : 'metodos de pago eliminados correctamente');
    }

    public function predetermined($id)
    {
        $repository = new PaymentMethodRepository();
        $object = $repository->getById($id);
        $object->predetermined = !$object->predetermined;
        $object->save();
        return redirect()->back()->with('success', 'metodo de pago establecido como predeterminado correctamente');
    }
}
