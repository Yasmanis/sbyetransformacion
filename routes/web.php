<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SelectsController;
use App\Http\Controllers\ContactsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia('landing/vivir_en_plenitud');
});

Route::get('/consulta_individual', function () {
    return Inertia('landing/consulta_individual');
});

Route::get('/taller_online', function () {
    return Inertia('landing/taller_online');
});

Route::get('/publicaciones', function () {
    return Inertia('landing/publicaciones');
});
Route::get('/publicaciones/libro', function () {
    return view('libros');
})->name('publicaciones.libro');

Route::get('/contactame', function () {
    return Inertia('landing/contactos');
});

Route::post('/contacts/store', [ContactsController::class, 'store']);

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate']);

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::get('/admin', function () {
        return Inertia('home');
    });
    Route::resource('/admin/users', UserController::class);
    Route::resource('/admin/rols', RoleController::class);
    Route::resource('/admin/categories', CategoryController::class);
    Route::resource('/admin/files', FileController::class);

    Route::get('/roles', [SelectsController::class, 'roles']);
    Route::get('/permissions', [SelectsController::class, 'permissions']);
    Route::get('/categories', [SelectsController::class, 'categories']);

    Route::get('/logout', [AuthController::class, 'logout']);
});