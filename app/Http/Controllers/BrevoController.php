<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BrevoController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'surname' => 'required|string', // Opcional, dependiendo de tu formulario
        ]);

        // Datos para enviar a la API de Brevo
        $data = [
            'email' => $request->email,
            'attributes' => [
                'FIRSTNAME' => $request->name,
                'LASTNAME' => $request->surname, // Atributos personalizados (opcional)
            ],
            'listIds' => [2], // IDs de las listas a las que se suscribirá el contacto
            'updateEnabled' => true, // Actualizar el contacto si ya existe
        ];

        // Configurar el cliente HTTP
        $client = new Client([
            'base_uri' => 'https://api.brevo.com/v3/contacts',
            'headers' => [
                'api-key' => env('BREVO_API_KEY'), // Asegúrate de tener tu API Key en el archivo .env
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);

        // Enviar la solicitud a la API de Brevo
        try {
            $response = $client->post('contacts', [
                'json' => $data,
            ]);

            return response()->json([
                'message' => 'Suscripción realizada correctamente',
                'response' => json_decode($response->getBody()->getContents()),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al realizar la suscripción',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
