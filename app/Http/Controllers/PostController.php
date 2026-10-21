<?php

namespace App\Http\Controllers;

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
            $module = $this->getModule();
            return Inertia::render('post/index', [
                'sections' => $this->getSections($module),
                'module' => $module,
                'category' => $category,
                'subcategories' => $category->subcategories,
                'files' => $category->files()->with('childs')->wherePrincipal()->orderBy('fixed', 'DESC')->orderBy('order', 'ASC')->get()
            ]);
        }
        return $this->deny_access($request);
    }
}
