<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class PayPalController extends Controller
{
    private $client;

    public function __construct()
    {
        $clientId = config('services.paypal.client_id');
        $clientSecret = config('services.paypal.client_secret');
        $environment = new SandboxEnvironment($clientId, $clientSecret);
        $this->client = new PayPalHttpClient($environment);
    }

    // Crear orden
    public function createOrder(Request $request)
    {
        $orderRequest = new OrdersCreateRequest();
        $orderRequest->prefer('return=representation');
        $orderRequest->body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => $request->amount // Ej: 10.00
                ]
            ]]
        ];

        try {
            $response = $this->client->execute($orderRequest);
            return response()->json($response->result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Capturar pago
    public function captureOrder(Request $request)
    {
        $captureRequest = new OrdersCaptureRequest($request->order_id);
        $captureRequest->prefer('return=representation');

        try {
            $response = $this->client->execute($captureRequest);

            // Aquí puedes guardar en BD, enviar email, etc.
            if ($response->result->status === 'COMPLETED') {
                // Lógica de pago exitoso
            }

            return response()->json($response->result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showOrder($orderId)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $order = $provider->showOrderDetails($orderId);
        return response()->json($order);
    }

    public function refundPayment($captureId)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $refund = $provider->refundCapturedPayment($captureId);
        return response()->json($refund);
    }
}
