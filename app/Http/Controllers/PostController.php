<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Module;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Override;

class PostController extends PlatformController
{

    #[Override]
    public function segment()
    {
        return 'post';
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $segment = $this->segment();
        if ($user->hasView('view_' . $segment) || $user->hasPerm('full_' . $segment)) {
            $category = $this->getCategory();
            return Inertia::render('post/index', [
                'sections' => $this->getSections(),
                'category' => $category,
                'files' => $category->files()->wherePrincipal()->get()
            ]);
        }
        return $this->deny_access($request);
    }
}
