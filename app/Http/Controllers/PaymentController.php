<?php

namespace App\Http\Controllers;

use App\Models\Payment;
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

        $response = $this->paypalService->createOrder($request->amount, $method, $information);

        if (isset($response['id']) && $response['status'] === 'CREATED') {
            Payment::create([
                'user_id' => auth()->id(),
                'order_id' => $response['id'],
                'status' => 'pending',
                'amount' => $request->amount,
                'currency' => 'EUR',
                'payload' => $response
            ]);
            session(['source_url' => url()->previous()]);
            return $response;
        }
        return response()->json(['error' => 'error creando la orden de pago'], 500);
    }

    public function success(Request $request)
    {
        $sourceUrl = $this->getSourceUrl();
        $orderId = $request->input('token');
        $response = $this->paypalService->capturePayment($orderId);
        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $payment = Payment::where('order_id', $orderId)->first();
            if ($payment) {
                $payment->update([
                    'status' => 'completed',
                    'payment_id' => $response['id'],
                    'payload' => $response
                ]);
                session()->flash('success', 'su pago fue procesado correctamente');
                return redirect()->to($sourceUrl);
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
