<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends LifeController
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $segment = $this->segment();
        if ($user->hasView('view_post') || $user->hasPerm('full_post')) {
            $category = Category::firstWhere('name', 'post');
            return Inertia::render('post/index', [
                'sections' => $user->getSections($segment),
                'private_messages' => $user->getPrivateMessages($request, 'received'),
                'files' => $category?->files ?? []
            ]);
        }
        return $this->deny_access($request);
    }
}
