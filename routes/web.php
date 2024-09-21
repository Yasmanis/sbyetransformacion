<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('vivir_en_plenitud');
});

Route::get('/consulta_individual', function () {
    return view('consulta_individual');
});

Route::get('/taller_online', function () {
    return view('taller_online');
});

Route::get('/publicaciones', function () {
    return view('publicaciones');
});
Route::get('/publicaciones/libro', function () {
    return view('libros');
})->name('publicaciones.libro');

Route::get('/contactos', function () {
    return view('contactos');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate']);

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::get('/admin', function () {
        return Inertia('home');
    });
    Route::resource('/admin/users', UserController::class);
    Route::get('/logout', [AuthController::class, 'logout']);
});
