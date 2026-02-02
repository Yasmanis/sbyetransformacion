<?php

return [
    'mode'    => env('PAYPAL_MODE', 'live'),
    'sandbox' => [
        'client_id'     => env('PAYPAL_SANDBOX_CLIENT_ID', ''),
        'client_secret' => env('PAYPAL_SANDBOX_SECRET', ''),
        'app_id'       => 'APP-80W284485P519543T',
    ],
    'live' => [
        'client_id'     => env('PAYPAL_LIVE_CLIENT_ID', ''),
        'client_secret' => env('PAYPAL_LIVE_CLIENT_SECRET', ''),
        'app_id'       => 'sbyetransformacion',
    ],
    'payment_action' => 'Sale',
    'currency'       => 'USD',
    'notify_url'     => '',
    'locale'        => 'es_ES',
    'validate_ssl'  => true,
];
