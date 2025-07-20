<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Inertia\Middleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        //dd($request);
        return array_merge(parent::share($request), [
            'csrf_token' => csrf_token(),
            'auth' => function () {
                $user = auth()->user();
                return $user ? [
                    'menu' => $user->menu(),
                    'user' => $user,
                    'permissions' => $user->getAllPermissions()->pluck('name'),
                ] : null;
            },
            'show_msg_subscription' => $request->session()->get('show_msg_subscription'),
            'public_path' => asset(''),
            'flash_success' => $request->session()->get('success'),
            'flash_error' => $request->session()->get('error'),
            'exclude_flash' => $request->session()->get('exclude_flash'),
            'loading' => [
                'exclude' => $request->session()->get('exclude_loading'),
                'message' => $request->session()->get('loading_msg')
            ],
            'object' => $request->session()->get('object'),
            'products_to_car' => []
        ]);
    }
}
