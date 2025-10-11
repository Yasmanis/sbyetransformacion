<?php

namespace App\Services;

use App\Models\Country;
use Carbon\Carbon;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Str;

class PayPalService
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
        $this->provider->getAccessToken();
    }

    public function createOrder($amount, $method = null, $information = null, $currency = 'EUR')
    {
        $country = Country::find($information['country_id']);
        // $requestId = 'PAYPAL_' . Str::uuid();
        // $this->provider->setRequestHeader('PayPal-Request-Id', $requestId);
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
                'cancel_url' => route('payment.cancel'),
                'locale' => 'es-ES'
            ],
            // 'payment_source' => [
            //     'card' => [
            //         'number' => str_replace(' ', '', $method['number']),
            //         'expiry' => Carbon::createFromFormat('m/Y', $method['defeat'])->format('Y-m'),
            //         'name' => $method['name'],
            //         'billing_address' => [
            //             "address_line_1" => $information['address'],
            //             "admin_area_2" => $information['province'],
            //             "postal_code" => $information['postal_code'],
            //             "country_code" => $country->iso2
            //         ]
            //     ]
            // ],
            'payer' => [
                "name" => [
                    "given_name" => $information['name'],
                    "surname" => $information['surname']
                ],
                "address" => [
                    "address_line_1" => $information['address'],
                    "address_line_2" => $information['road'],
                    "admin_area_2" => $information['province'],
                    "admin_area_1" => $country->name,
                    "postal_code" => $information['postal_code'],
                    "country_code" => $country->iso2
                ]
            ],
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
