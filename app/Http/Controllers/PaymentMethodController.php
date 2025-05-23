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

    public function destroy(Request $request, $id)
    {
        $repository = new PaymentMethodRepository();
        $repository->deleteById($id);
        return redirect()->back()->with('success', 'metodo de pago eliminado correctamente');
    }
}