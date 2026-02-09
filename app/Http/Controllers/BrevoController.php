<?php

namespace App\Http\Controllers;

use App\Services\BrevoService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class BrevoController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'surname' => 'required|string',
        ]);
        $data = [
            'email' => $request->email,
            'attributes' => [
                'FIRSTNAME' => $request->name,
                'LASTNAME' => $request->surname,
            ],
            'listIds' => [3]
        ];
        $client = new Client([
            'base_uri' => 'https://api.brevo.com/v3/contacts',
            'verify' => env('VERIFY_SSL', true),
            'headers' => [
                'api-key' => env('BREVO_API_KEY'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
        try {
            $response = $client->post('contacts', [
                'json' => $data,
            ]);
            try {
                $service = new BrevoService();
                $params = [
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'email' => $request->email
                ];
                $service->sendEmail('AVISO - nuevo usuario', 'admin.subscription', $params);
            } catch (\Throwable $th) {
                //throw $th;
            }
            return redirect()->back()->with(
                'object',
                $response->getBody()->getContents()
            );
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'object',
                $e->getMessage()
            );
        }
    }
}
