<?php

use App\Models\PushMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Traits\DateUtils;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/test-next-date', function (Request $request) {
    $date = Carbon::createFromFormat('Y-m-d', '2025-03-05');
    $period = $request->period;
    $p = new PushMessage();
    dd($p->nextDateFromPeriod($date, $period)->format('d-m-Y'));
});