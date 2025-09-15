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

    public function create(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $response = $this->paypalService->createOrder($request->amount);

        if (isset($response['id']) && $response['status'] === 'CREATED') {
            Payment::create([
                'user_id' => auth()->id(),
                'order_id' => $response['id'],
                'status' => 'pending',
                'amount' => $request->amount,
                'currency' => 'USD',
                'payload' => $response
            ]);

            return redirect()->away($links['href']);

            return response()->json([
                'orderID' => $response['id'],
                'approvalURL' => collect($response['links'])
                    ->where('rel', 'approve')
                    ->first()['href']
            ]);
        }

        return response()->json(['error' => 'Error creating order'], 500);
    }

    public function success(Request $request)
    {
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

                return Inertia::render('Payment/Success', [
                    'payment' => $payment
                ]);
            }
        }

        return redirect()->route('payment.failed');
    }

    public function cancel()
    {
        return Inertia::render('Payment/Cancel');
    }

    public function details(Request $request, $id)
    {
        $response = $this->paypalService->capturePayment($id);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $payment = Payment::where('order_id', $id)->first();

            if ($payment) {
                $payment->update([
                    'status' => 'completed',
                    'payment_id' => $id,
                    'payload' => $response
                ]);

                return Inertia::render('Payment/Success', [
                    'payment' => $payment
                ]);
            }
        }

        return redirect()->route('payment.failed');
    }
}
