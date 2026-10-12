<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Repositories\FileRepository;
use App\Repositories\SchoolSectionsRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Override;

class IntheMediaController extends LifeController
{
    #[Override]
    public function segment()
    {
        return 'inthemedia';
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $segment = $this->segment();
        if ($user->hasView('view_inthemedia') || $user->hasPerm('full_inthemedia')) {
            $category = Category::firstWhere('name', 'en los medios');
            $module = $this->getModule();
            return Inertia::render('in_the_media/index', [
                'sections' => $this->getSections($module),
                'module' => $module,
                'private_messages' => $user->getPrivateMessages($request, 'received'),
                'category' => $category,
                'files' => $category?->files ?? []
            ]);
        }
        return $this->deny_access($request);
    }
}
