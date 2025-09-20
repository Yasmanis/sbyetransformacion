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

    public function createOrder($amount, $method, $information, $currency = 'EUR')
    {
        $user = auth()->user();
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
            ],
            // 'payer' => [
            //     'name' => [
            //         'given_name' => $user->name,
            //         'surname' => $user->surname
            //     ],
            //     'email_address' => $user->email,
            //     'phone' => [
            //         'phone_type' => 'MOBILE',
            //         'phone_number' => [
            //             'national_number' => $user->phone
            //         ]
            //     ],
            //     'address' => [
            //         'address_line_1' => $user->address_line_1,
            //         'address_line_2' => $user->address_line_2,
            //         'admin_area_2' => $user->city,
            //         'admin_area_1' => $user->state,
            //         'postal_code' => $user->postal_code,
            //         'country_code' => $user->country_code
            //     ]
            // ]
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
