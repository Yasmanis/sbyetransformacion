<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SelectsController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\LifeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\SchoolTopicsController;
use App\Models\Category;
use App\Models\Configuration;
use App\Models\File;
use App\Models\SchoolTopic;
use Illuminate\Http\Request;
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

Route::get('/publicaciones', function (Request $request) {
    $categories = Category::with('files')->get();
    $recent_files = File::latest()->take(6)->get();
    return Inertia('landing/publicaciones', ['categories' => $categories, 'recent_files' => $recent_files]);
});

Route::get('/publicaciones1', function (Request $request) {
    $categories = Category::with('files')->get();
    $recent_files = File::latest()->take(6)->get();
    return Inertia('landing/publicaciones1', ['categories' => $categories, 'recent_files' => $recent_files]);
});

Route::get('/contactame', function () {
    return Inertia('landing/contactos');
});

Route::get('/legal', function () {
    $config = Configuration::where('key', 'legal')->first();
    return Inertia('landing/legal', ['config' => $config]);
});

Route::get('/private', function () {
    $config = Configuration::where('key', 'private')->first();
    return Inertia('landing/private', ['config' => $config]);
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
    Route::resource('/admin/life', LifeController::class);
    Route::resource('/admin/schooltopics', SchoolTopicsController::class);
    Route::post('/admin/schooltopics/addResources', [SchoolTopicsController::class, 'addResource']);
    Route::delete('/admin/schooltopics/deleteResource/{id}', [SchoolTopicsController::class, 'deleteResource']);
    Route::post('/admin/categories/sort-files', [CategoryController::class, 'sortFiles']);
    Route::resource('/admin/files', FileController::class);

    Route::get('/roles', [SelectsController::class, 'roles']);
    Route::get('/permissions', [SelectsController::class, 'permissions']);
    Route::get('/admin/posts', [PostController::class, 'index']);
    Route::get('/admin/newsletter', [NewsletterController::class, 'index']);

    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/admin/configuration/legal', [ConfigurationController::class, 'legal']);
    Route::get('/admin/configuration/private', [ConfigurationController::class, 'private']);
    Route::get('/admin/configuration/index/{keyName}', [ConfigurationController::class, 'index']);
    Route::post('/admin/configuration/save', [ConfigurationController::class, 'save']);
});

Route::get('/categories', [SelectsController::class, 'categories']);
Route::get('/type-of-files', [SelectsController::class, 'typeOfFiles']);
Route::get('/download/{id}', [FileController::class, 'download']);
