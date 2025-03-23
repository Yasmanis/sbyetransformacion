<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BrevoService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('BREVO_API_KEY');
    }

    public function sendEmail($to, $templateId, $params)
    {
        $url = 'https://api.brevo.com/v3/smtp/email';

        $data = [
            'sender' => [
                'name' => env('APP_NAME'),
                'email' => env('MAIL_FROM_ADDRESS'),
            ],
            'to' => [
                [
                    'email' => $to['email'],
                    'name' => $to['name'],
                ],
            ],
            'templateId' => $templateId,
            'params' => $params,
        ];

        $response = Http::withHeaders([
            'api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($url, $data);

        if ($response->successful()) {
            return ['success' => true, 'data' => $response->json()];
        } else {
            return ['success' => false, 'error' => $response->json()];
        }
    }
}