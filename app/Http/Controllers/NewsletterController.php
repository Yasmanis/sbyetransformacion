<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsletterController extends LifeController
{

    public function index(Request $request)
    {
        $user = auth()->user();
        $segment = $this->segment();
        if ($user->hasView('view_newsletter') || $user->hasPerm('full_newsletter')) {
            $category = Category::firstWhere('name', 'newsletters');
            $module = $this->getModule();
            return Inertia::render('newsletter/index', [
                'sections' => $this->getSections($module),
                'module' => $module,
                'course_percentage' => $user->getCoursePercentage($segment),
                'private_messages' => $user->getPrivateMessages($request, 'received'),
                'files' => $category?->files ?? []
            ]);
        }
        return $this->deny_access($request);
    }
}
