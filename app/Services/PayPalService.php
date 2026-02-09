<?php

namespace App\Services;

use App\Models\Country;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalService
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
        $this->provider->getAccessToken();

        // $token = $this->provider->getAccessToken();
        // if (isset($token['error'])) {
        //     dd([
        //         'Causa' => 'Error de Autenticación',
        //         'Detalle' => $token,
        //         'Config_Usada' => config('paypal.mode')
        //     ]);
        // }
    }

    public function createOrder($amount, $method = null, $information = null, $currency = 'EUR')
    {
        $config  = [
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
        ];
        if (isset($information)) {
            $country = Country::find($information['country_id']);
            $config['payer'] = [
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
            ];
        }
        $response = $this->provider->createOrder($config);
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
