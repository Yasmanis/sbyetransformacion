<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;

class BrevoService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('BREVO_API_KEY');
    }

    public function sendEmail($subject, $view, $params, $to = null)
    {
        // $to = [
        //     'email' => 'yfdezmerino91@gmail.com',
        //     'name' => 'Yosvani'
        // ];
        $url = 'https://api.brevo.com/v3/smtp/email';
        $html = View::make(sprintf('emails.%s', $view), $params)->render();
        $html = preg_replace('/>\s+</', '><', $html);
        $html = trim($html);
        $data = [
            'sender' => [
                'name' => env('APP_NAME'),
                'email' => env('MAIL_FROM_ADDRESS'),
            ],
            'to' => [
                [
                    'email' => $to['email'] ?? env('MAIL_ADMIN'),
                    'name' => $to['name'] ?? env('NAME_ADMIN'),
                ],
            ],
            'subject' => $subject,
            'htmlContent' => $html,
            'tags' => ['transactional']
        ];
        $response = Http::withHeaders([
            'api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->withOptions(['verify' => false])->post($url, $data);
        if ($response->successful()) {
            return ['success' => true, 'data' => $response->json()];
        } else {
            return ['success' => false, 'error' => $response->json()];
        }
    }
}
