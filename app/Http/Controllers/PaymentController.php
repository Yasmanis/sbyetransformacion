<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PayPalService;

class PaymentController extends Controller
{
    protected $paypalService;

    public function __construct(PayPalService $paypalService)
    {
        $this->paypalService = $paypalService;
    }

    public function createPayment(Request $request)
    {
        $amount = 100.00;
        $description = 'Compra en Mi Tienda';

        $payment = $this->paypalService->createPayment(
            $amount,
            $description,
            route('payment.success'),
            route('payment.cancel')
        );

        return redirect($payment->getApprovalLink());
    }

    public function paymentSuccess(Request $request)
    {
        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');

        try {
            $payment = $this->paypalService->executePayment($paymentId, $payerId);

            // Aquí puedes guardar los datos del pago en tu base de datos
            // y procesar el pedido

            return view('payments.success', compact('payment'));
        } catch (\Exception $ex) {
            return redirect()->route('payment.cancel')->withErrors(['error' => $ex->getMessage()]);
        }
    }

    public function paymentCancel()
    {
        return view('payments.cancel');
    }
}
