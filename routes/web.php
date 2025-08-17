<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BillingInformationController;
use App\Http\Controllers\BrevoController;
use App\Http\Controllers\BriefIdeasController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SelectsController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\LifeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\ContactAdminController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PrivateMsgController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDiscountController;
use App\Http\Controllers\ProductOffersController;
use App\Http\Controllers\PushMessageController;
use App\Http\Controllers\ReasonForReturnController;
use App\Http\Controllers\SchoolTopicsController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\TestimonyController;
use App\Models\Category;
use App\Models\Configuration;
use App\Models\File;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Testimony;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Pusher\Pusher;
use Pusher\PushNotifications\PushNotifications;

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
    //broadcast(new PushMessage('hola'));

    //event(new PushMessage('hola'));

    //event(new PushMessage('hello world'));

    $pusher = new Pusher('e63f90f776ecf0234b4e', '09a25e84a2a310ad02a2', '1930615', array('cluster' => 'us2'));
    $pusher->trigger('my-channel', 'my-event', [
        'title' => 'titulo',
        'text' => 'ejemplo de texto a mostrar',
        'icon' => 'mdi-account',
        'sent_at' => now(),
        'user' => auth()->user()->id
    ]);
});



Route::get('/listen', function () {
    return Inertia::render('pushmessages/notification');
});

Route::get('/', function () {
    return Inertia('landing/vivir_en_plenitud');
});

Route::get('/liberacion_emocional', function () {
    $testimonies = Testimony::active()->type('text')->get();
    return Inertia('landing/free_learning', ['testimonies' => $testimonies]);
});

Route::get('/consulta_individual', function () {
    return Inertia('landing/consulta_individual');
});

Route::get('/taller_online', function () {
    return Inertia('landing/taller_online');
});

Route::get('/maria', function () {
    return Inertia('landing/maria');
});

Route::get('/store', function () {
    $products = Product::public()->get();
    return Inertia('landing/store', [
        'products' => $products
    ]);
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
        $testimonies = Testimony::active()->with('user')->orderBy('type', 'DESC')->orderBy('order', 'ASC')->get();
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

Route::get('/contracting', function () {
    $config = Configuration::where('key', 'contracting')->first();
    return Inertia('landing/contracting', ['config' => $config]);
});

Route::post('/contacts/store', [ContactsController::class, 'store']);

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate']);
Route::post('/getPassword', [AuthController::class, 'getPassword']);
Route::post('/buyer-register', [AuthController::class, 'buyerRegister']);
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('guest');

Route::get('/shared-file/{id}/{only_file?}', function ($id, $only = null) {
    $id = base64_decode($id);
    $file = File::find($id);
    if ($file != null) {
        if ($only) {
            $filePath = public_path() . '/storage/' . $file->path;

            if (!file_exists($filePath)) {
                abort(404);
            }

            // Determinar el tipo MIME dinámicamente
            $mime = mime_content_type($filePath);

            return response()->file($filePath, [
                'Content-Type' => $mime,
                'Content-Disposition' => 'inline' // Para visualización en navegador
            ]);
        } else return Inertia('shared/file', [
            'file' => $file
        ]);
    }
    return redirect('not-found');
})->name('shared-file');

Route::get('/not-found', function () {
    return Inertia('errors/notFound');
})->name('not-found');

Route::get('/checkout', function () {
    return Inertia('payments/checkout');
})->name('checkout');

Route::post('/create-payment', [PaymentController::class, 'createPayment'])->name('create.payment');
Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');

Route::middleware(['auth', 'auth.session'])->group(function () {

    Route::post('/pusher/auth', function (Request $request) {
        $beamsClient = new PushNotifications(array(
            "instanceId" => "556c8ed1-ac33-4910-883f-16287ddf1ab8",
            "secretKey" => "E59B83DE274A8D03C12890A8B34599000CD80406A6963FB0E8D76D845AD443E6",
        ));
        $token = $beamsClient->generateToken(auth()->user()->id);
        return $token;
    });

    Route::get('/auth/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/auth/profile', [AuthController::class, 'saveProfile']);
    Route::post('/auth/subscribe', [AuthController::class, 'subscribe']);
    Route::post('/auth/change-avatar', [AuthController::class, 'changeAvatar']);
    Route::post('/auth/store-new-book', [AuthController::class, 'storeNewBook']);
    Route::delete('/auth/delete-notification/{ids}', [AuthController::class, 'deleteNotification']);
    Route::post('/auth/read-unread-notification/{id}', [AuthController::class, 'readUnreadNotification']);
    Route::post('/auth/mark-notifications-as', [AuthController::class, 'markNotificationsAs']);
    Route::get('/admin', function () {
        return Inertia('home');
    });
    Route::resource('/admin/users', UserController::class);
    Route::post('/admin/users/lockUnlock/{id}', [UserController::class, 'lockUnlock']);
    Route::post('/admin/users/change-password/{id}', [UserController::class, 'changePassword']);
    Route::post('/admin/users/change-my-password', [UserController::class, 'changeMyPassword']);
    Route::post('/admin/users/update-last-courses', [UserController::class, 'updateLastCourses']);
    Route::post('/admin/users/change-theme', [UserController::class, 'changeTheme']);
    Route::post('/admin/users/progress/{id}', [UserController::class, 'progress']);
    Route::post('/admin/users/comments/{id}', [UserController::class, 'comments']);
    Route::resource('/admin/rols', RoleController::class);
    Route::resource('/admin/categories', CategoryController::class);

    Route::resource('/admin/testimony', TestimonyController::class);
    Route::post('/admin/testimony/sort', [TestimonyController::class, 'sort']);

    Route::resource('/admin/push-messages', PushMessageController::class);
    Route::get('/admin/push-messages/change-status/{id}', [PushMessageController::class, 'changeStatus']);
    Route::resource('/admin/campaigns', CampaignController::class);
    Route::resource('/admin/countries', CountryController::class);
    Route::resource('/admin/reason-for-return', ReasonForReturnController::class);
    Route::resource('/admin/products', ProductController::class);
    Route::resource('/admin/offers', ProductOffersController::class)->only(['store', 'update', 'destroy']);
    Route::resource('/admin/discounts', ProductDiscountController::class)->only(['store', 'update', 'destroy']);
    Route::post('/admin/products/offers/{id}', [ProductOffersController::class, 'index']);
    Route::post('/admin/products/discounts/{id}', [ProductDiscountController::class, 'index']);
    Route::post('/admin/products/subtitle', [ProductController::class, 'addSubtitle']);
    Route::put('/admin/products/subtitle/{id}', [ProductController::class, 'updateSubtitle']);
    Route::delete('/admin/products/subtitle/{id}', [ProductController::class, 'deleteSubtitle']);
    Route::post('/admin/products/public/{id}', [ProductController::class, 'public']);
    Route::resource('/admin/product-categories', ProductCategoryController::class);
    Route::resource('/admin/users/payment-methods', PaymentMethodController::class)->except('index');
    Route::resource('/admin/users/billing-information', BillingInformationController::class)->except('index');
    Route::post('/admin/users/billing-information/predetermined/{id}', [BillingInformationController::class, 'predetermined']);
    Route::get('/admin/campaigns/logo/{id}', [CampaignController::class, 'logo']);
    Route::resource('/admin/briefideas', BriefIdeasController::class);
    Route::post('/admin/briefideas/fixed/{id}', [BriefIdeasController::class, 'fixed']);
    Route::post('/admin/briefideas/config-notification/{id}', [BriefIdeasController::class, 'configNotification']);
    Route::resource('/admin/messages', MessagesController::class);

    Route::post('/admin/testimony/publicated/{id}', [TestimonyController::class, 'publicated']);
    Route::post('/admin/testimony/store-from-publications', [TestimonyController::class, 'storeFromPublications']);
    Route::resource('/admin/school', LifeController::class);
    Route::resource('/admin/conference', ConferenceController::class);
    Route::resource('/admin/learning', LearningController::class);
    Route::resource('/admin/schooltopics', SchoolTopicsController::class);
    Route::post('/admin/schooltopics/sort-topics', [SchoolTopicsController::class, 'sortTopics']);
    Route::post('/admin/schooltopics/addResources', [SchoolTopicsController::class, 'addResource']);
    Route::delete('/admin/schooltopics/deleteResource/{id}', [SchoolTopicsController::class, 'deleteResource']);
    Route::post('/admin/schooltopics/update-video-percentaje-to-user', [SchoolTopicsController::class, 'updateVideoPercentage']);
    Route::post('/admin/schooltopics/add-message/{id}', [SchoolTopicsController::class, 'addMessage']);
    Route::post('/admin/schooltopics/edit-message/{id}', [SchoolTopicsController::class, 'editMessage']);
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
    Route::resource('/admin/shopping', ShoppingController::class);
    Route::post('/admin/files/poster/{id}', [FileController::class, 'poster']);
    Route::post('/admin/files/public-access/{id}', [FileController::class, 'publicAccess']);
    Route::resource('/admin/private-message', PrivateMsgController::class)->except(['index']);
    Route::get('/admin/private-message/download/{id}', [PrivateMsgController::class, 'download']);
    Route::post('/admin/private-message/highlight/{id}', [PrivateMsgController::class, 'highlight']);
    Route::put('/admin/private-message/read/{id}', [PrivateMsgController::class, 'read']);
    Route::resource('/admin/sections', SectionsController::class);

    Route::get('/roles', [SelectsController::class, 'roles']);
    Route::get('/permissions', [SelectsController::class, 'permissions']);
    Route::get('/users', [SelectsController::class, 'users']);
    Route::get('/reasons-for-return', [SelectsController::class, 'reasonsForReturn']);
    Route::post('/users', [SelectsController::class, 'users']);
    Route::get('/category-nomenclatures/{key}', [SelectsController::class, 'sections']);
    Route::get('/selects/campaigns', [SelectsController::class, 'campaigns']);
    Route::get('/admin/posts', [PostController::class, 'index']);
    Route::get('/admin/newsletter', [NewsletterController::class, 'index']);

    Route::get('/admin/configuration/legal', [ConfigurationController::class, 'legal']);
    Route::get('/admin/configuration/private', [ConfigurationController::class, 'private']);
    Route::get('/admin/configuration/index/{keyName}', [ConfigurationController::class, 'index']);
    Route::post('/admin/configuration/save', [ConfigurationController::class, 'save']);
    Route::post('/admin/contact-admin/store', [ContactAdminController::class, 'store']);

    Route::post('/contacts/change-book-volume/{id}', [ContactsController::class, 'changeBookVolume']);

    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::get('/categories', [SelectsController::class, 'categories']);
Route::get('/countries', [SelectsController::class, 'countries']);
Route::get('/type-of-files', [SelectsController::class, 'typeOfFiles']);
Route::get('/download/{id}', [FileController::class, 'download']);
Route::post('/subscribe', [BrevoController::class, 'subscribe']);
Route::get('/product-categories', [SelectsController::class, 'productCategories']);
