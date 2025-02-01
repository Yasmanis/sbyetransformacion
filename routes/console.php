<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('event', function () {
    Log::info('inicializando conexxion');
    $pusher = new Pusher('e63f90f776ecf0234b4e', '09a25e84a2a310ad02a2', '1930615', array('cluster' => 'us2'));
    $pusher->trigger('my-channel', 'my-event', [
        'title' => 'titulo',
        'text' => 'ejemplo de texto a mostrar',
        'icon' => 'mdi-account',
        'sent_at' => now(),
        'user' => auth()->user()->id
    ]);
})->purpose('Ejemplo de envio de notificaciones push');