<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\PushMessageConfigNotification;
use App\Models\PushMessageFixedUser;
use Illuminate\Http\Request;
use App\Repositories\PushMessageRepository;
use App\Services\BrevoService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class StoreController extends PushMessageController
{
    public function segment()
    {
        return 'briefidea';
    }

    public function index(Request $request)
    {
        $categories = ProductCategory::whereHas('subcategories', function ($subcategoryQuery) {
            $subcategoryQuery->whereHas('products');
        })->with(['subcategories' => function ($query) {
            $query->whereHas('products')
                ->orderBy('order', 'asc')->with('subtitles');
        }, 'subcategories.products' => function ($query) {
            $query->orderBy('order', 'asc')->with('subtitles');
        }])->orderBy('order', 'asc')->with('subtitles')->get();
        return Inertia('landing/store', [
            'categories' => $categories
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
            return back()->with(['success' => 'su duda ha sido registrada correctamente, se le responderá a traves del correo especificado']);
        }
        return back()->with(['error' => $result['error']['message']]);
    }
}
