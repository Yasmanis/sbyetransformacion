<?php

use App\Events\PushMessage;
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
use App\Http\Controllers\PushMessageController;
use App\Http\Controllers\SchoolTopicsController;
use App\Http\Controllers\TestimonyController;
use App\Models\Category;
use App\Models\Configuration;
use App\Models\File;
use App\Models\PasswordChangeNotification;
use App\Models\Testimony;
use App\Models\User;
use App\Notifications\StandardNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
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

Route::get('/event', function () {
    event(new PushMessage('Send from server to Pusher!'));
});

Route::get('/listen', function () {
    return Inertia::render('pushmessages/notification');
});

Route::get('/', function () {
    return Inertia('landing/vivir_en_plenitud');
});

Route::get('/consulta_individual', function () {
    return Inertia('landing/consulta_individual');
});

Route::get('/taller_online', function () {
    return Inertia('landing/taller_online');
});

Route::get('/publicaciones/{id?}', function (Request $request, $id = null) {
    $categories = Category::where('public_access', true)->orderBy('order', 'ASC')->get();
    $recent_files = File::publicAccess()->orderBy('public_date', 'DESC')->take(6)->get();
    $category = null;
    $testimonies = [];
    if (count($categories) > 0) {
        $category = $categories[0];
    }
    if (isset($id)) {
        $c = Category::find($id);
        if ($c && $c->public_access) {
            $category = $c;
        } else {
            return to_route('publicaciones');
        }
    }
    if (isset($category)) {
        $files = File::where('category_id', $category->id)->publicAccess()->orderBy('order', 'ASC')->get();
        $category->files = $files;
    }
    if ($category->name == 'testimonios') {
        $testimonies = Testimony::active()->with('user')->orderBy('type', 'DESC')->get();
    }
    return Inertia('landing/publicaciones', ['categories' => $categories, 'current_category' => $category, 'recent_files' => $recent_files, 'testimonies' => $testimonies])->with('error', 'asasdasd');
})->name('publicaciones');

Route::get('/contactame', function () {
    return Inertia('landing/contactos');
});

Route::get('/brevo', function () {
    return view('brevo');
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
Route::post('/getPassword', [AuthController::class, 'getPassword']);

Route::get('/shared-file/${id}', function ($id) {
    $id = base64_decode($id);
    $file = File::find($id);
    if ($file != null) {
        return Inertia('shared/file', [
            'file' => $file
        ]);
    }
    return redirect('not-found');
})->name('shared-file');

Route::get('/not-found', function () {
    return Inertia('errors/notFound');
})->name('not-found');

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::get('/auth/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/auth/profile', [AuthController::class, 'saveProfile']);
    Route::post('/auth/store-new-book', [AuthController::class, 'storeNewBook']);
    Route::get('/admin', function () {
        return Inertia('home');
    });
    Route::resource('/admin/users', UserController::class);
    Route::post('/admin/users/lockUnlock/{id}', [UserController::class, 'lockUnlock']);
    Route::post('/admin/users/change-password/{id}', [UserController::class, 'changePassword']);
    Route::post('/admin/users/change-my-password', [UserController::class, 'changeMyPassword']);
    Route::post('/admin/users/change-theme', [UserController::class, 'changeTheme']);
    Route::resource('/admin/rols', RoleController::class);
    Route::resource('/admin/categories', CategoryController::class);
    Route::resource('/admin/testimony', TestimonyController::class);
    Route::resource('/admin/push-messages', PushMessageController::class);
    Route::post('/admin/testimony/publicated/{id}', [TestimonyController::class, 'publicated']);
    Route::post('/admin/testimony/store-from-publications', [TestimonyController::class, 'storeFromPublications']);
    Route::resource('/admin/life', LifeController::class);
    Route::post('/admin/life/sort-topics', [SchoolTopicsController::class, 'sortTopics']);
    Route::resource('/admin/schooltopics', SchoolTopicsController::class);
    Route::post('/admin/schooltopics/addResources', [SchoolTopicsController::class, 'addResource']);
    Route::delete('/admin/schooltopics/deleteResource/{id}', [SchoolTopicsController::class, 'deleteResource']);
    Route::post('/admin/schooltopics/update-video-percentaje-to-user', [SchoolTopicsController::class, 'updateVideoPercentage']);
    Route::post('/admin/schooltopics/add-message/{id}', [SchoolTopicsController::class, 'addMessage']);
    Route::delete('/admin/schooltopics/delete-message/{id}', [SchoolTopicsController::class, 'deleteMsg']);
    Route::post('/admin/schooltopics/clear-chat/{id}', [SchoolTopicsController::class, 'clearChat']);
    Route::post('/admin/schooltopics/react-message/{id}', [SchoolTopicsController::class, 'reactMsg']);
    Route::post('/admin/schooltopics/highligth-message/{id}', [SchoolTopicsController::class, 'highligthMsg']);
    Route::post('/admin/schooltopics/add-attachment-message', [SchoolTopicsController::class, 'addAttachmentToMsg']);
    Route::post('/admin/categories/sort-files', [CategoryController::class, 'sortFiles']);
    Route::post('/admin/categories/sort-categories', [CategoryController::class, 'sortCategories']);
    Route::post('/admin/categories/public-access/{id}', [CategoryController::class, 'publicAccess']);
    Route::post('/admin/categories/private-area/{id}', [CategoryController::class, 'privateArea']);
    Route::resource('/admin/files', FileController::class);
    Route::post('/admin/files/poster/{id}', [FileController::class, 'poster']);
    Route::post('/admin/files/public-access/{id}', [FileController::class, 'publicAccess']);

    Route::get('/roles', [SelectsController::class, 'roles']);
    Route::get('/permissions', [SelectsController::class, 'permissions']);
    Route::get('/users', [SelectsController::class, 'users']);
    Route::post('/users', [SelectsController::class, 'users']);
    Route::get('/admin/posts', [PostController::class, 'index']);
    Route::get('/admin/newsletter', [NewsletterController::class, 'index']);

    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/admin/configuration/legal', [ConfigurationController::class, 'legal']);
    Route::get('/admin/configuration/private', [ConfigurationController::class, 'private']);
    Route::get('/admin/configuration/index/{keyName}', [ConfigurationController::class, 'index']);
    Route::post('/admin/configuration/save', [ConfigurationController::class, 'save']);

    Route::post('/contacts/change-book-volume/{id}', [ContactsController::class, 'changeBookVolume']);
});

Route::get('/categories', [SelectsController::class, 'categories']);
Route::get('/type-of-files', [SelectsController::class, 'typeOfFiles']);
Route::get('/download/{id}', [FileController::class, 'download']);
