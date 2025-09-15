<?php

namespace App\Services;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalService
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
        $this->provider->getAccessToken();
    }

    public function createOrder($amount, $currency = 'USD')
    {
        $response = $this->provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => $currency,
                        'value' => $amount
                    ]
                ]
            ],
            'application_context' => [
                'return_url' => route('payment.success'),
                'cancel_url' => route('payment.cancel')
            ]
        ]);

        return $response;
    }

    public function capturePayment($orderId)
    {
        return $this->provider->capturePaymentOrder($orderId);
    }

    public function getOrderDetails($orderId)
    {
        return $this->provider->showOrderDetails($orderId);
    }
}
