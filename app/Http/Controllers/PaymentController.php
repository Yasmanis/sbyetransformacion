<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentProduct;
use App\Models\Product;
use App\Services\PayPalService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    protected $paypalService;

    public function __construct(PayPalService $paypalService)
    {
        $this->paypalService = $paypalService;
    }

    public function create()
    {
        return Inertia::render('payments/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $method = $request->method;
        $information = $request->information;

        $amount = 0;
        $temp = [];
        foreach ($request->products as $p) {
            $product = Product::find($p['id']);
            if ($product) {
                $amount += $product->final_price;
                $temp[] = [
                    'payment_id' => null,
                    'product_id' => $p['id'],
                    'amount' => $product->final_price
                ];
            }
        }

        if ($amount > 0) {

            $response = $this->paypalService->createOrder($request->amount, $method, $information);

            if (isset($response['id']) && $response['status'] === 'CREATED') {
                $object = Payment::create([
                    'user_id' => auth()->id(),
                    'order_id' => $response['id'],
                    'status' => 'pending',
                    'amount' => $amount,
                    'currency' => 'EUR',
                    'payload' => $response
                ]);

                foreach ($temp as $p) {
                    $p['payment_id'] = $object->id;
                }
                PaymentProduct::create($temp);

                session(['source_url' => url()->previous()]);
                return $response;
            }
        }

        return response()->json(['error' => 'error creando la orden de pago'], 500);
    }

    public function success(Request $request)
    {
        $sourceUrl = $this->getSourceUrl();
        $orderId = $request->input('token');
        $response = $this->paypalService->capturePayment($orderId);
        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $payment = Payment::with('products.course.permissions')->firstWhere('order_id', $orderId);
            if ($payment) {
                $payment->update([
                    'status' => 'completed',
                    'payment_id' => $response['id'],
                    'payload' => $response
                ]);

                $permissionsToGrant = $payment->products
                    ->pluck('course')
                    ->filter()
                    ->pluck('permissions')->where('name', 'like', '%view%')
                    ->flatten()
                    ->pluck('id');

                dd($permissionsToGrant);

                $user = auth()->user();

                if (!$user->sa && $permissionsToGrant->isNotEmpty()) {
                    $user->givePermissionTo($permissionsToGrant);
                }

                session()->flash('success', 'su pago fue procesado correctamente');

                $url = $payment->products[0]->course->base_url;
                return redirect()->to($url);
            }
        }
        session()->flash('error', 'error al procesar su pago');
        return redirect()->to($sourceUrl);
    }

    public function cancel(Request $request)
    {
        $orderId = $request->input('token');
        $payment = Payment::where('order_id', $orderId)->first();
        if ($payment) {
            $payment->update([
                'status' => 'canceled',
            ]);
        }
        $sourceUrl = $this->getSourceUrl();
        session()->flash('success', 'su pago fue cancelado');
        return redirect()->to($sourceUrl);
    }

    public function getSourceUrl()
    {
        $sourceUrl = session('source_url', url('/store'));
        if (!filter_var($sourceUrl, FILTER_VALIDATE_URL) || !str_contains($sourceUrl, config('app.url'))) {
            $sourceUrl = url('/store');
        }
        return $sourceUrl;
    }
}
