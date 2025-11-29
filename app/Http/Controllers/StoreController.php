<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use App\Models\PushMessageConfigNotification;
use App\Models\PushMessageFixedUser;
use App\Models\User;
use App\Models\UserNotifications;
use App\Notifications\StandardNotification;
use Illuminate\Http\Request;
use App\Repositories\PushMessageRepository;
use App\Services\BrevoService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;

class StoreController extends PushMessageController
{
    public function segment()
    {
        return 'briefidea';
    }

    public function index(Request $request)
    {
        $categories = ProductCategory::whereHas(
            'subcategories',
            fn($subcategoryQuery) =>
            $subcategoryQuery->whereHas('products', fn($productQuery) => $productQuery->active())
        )->with([
            'subcategories' => fn($query) =>
            $query->whereHas('products', fn($productQuery) => $productQuery->active())
                ->orderBy('order', 'asc')
                ->with('subtitles'),
            'subcategories.products' => fn($query) =>
            $query->active()
                ->orderBy('order', 'asc')
                ->with('subtitles')
        ])
            ->orderBy('order', 'asc')
            ->with('subtitles')
            ->get();

        $subcategories = ProductSubcategory::whereHas('products', fn($productQuery) => $productQuery->active())
            ->orderBy('order', 'asc')
            ->get();

        return Inertia('landing/store', [
            'categories' => $categories,
            'subcategories' => $subcategories
        ]);
    }

    public function sendQuestion(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'surname' => 'required|string',
            'question' => 'required|string',
        ]);
        $product = Product::find($request->product);
        $params = [
            'name' => sprintf('%s %s', $request->name, $request->surname),
            'email' => $request->email,
            'product' => $product->name ?? 'no definido',
            'question' => $request->question
        ];
        $brevoService = new BrevoService();
        $result = $brevoService->sendEmail('duda desde la tienda', 'store.question', $params);
        if ($result['success']) {
            $notification = new UserNotifications();
            $notification->title = 'duda desde la tienda';
            $notification->priority = 'Alta';
            $notification->description = sprintf('el usuario con correo <b>%s</b> le ha enviado una duda desde la tienda', $request->email);
            $notification->code = 'store_question';
            $notification->save();

            $users = User::isAdmin()->get();
            Notification::send($users, new StandardNotification($notification));

            return back()->with(['success' => 'su duda ha sido registrada correctamente, se le responderá a traves del correo especificado']);
        }
        return back()->with(['error' => $result['error']['message']]);
    }
}
