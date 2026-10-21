<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class BookVideoController extends LifeController
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $segment = $this->segment();
        if ($user->hasView($segment) || ($segment == 'school' && $user->hasPerm('full_school'))) {
            $module = $this->getModule();
            return Inertia::render('life/school', [
                'sections' => $this->getSections($module),
                'module' => $module,
                'course_percentage' => $user->getCoursePercentage($segment),
                'private_messages' => $user->getPrivateMessages($request, 'received')
            ]);
        }
        return $this->deny_access($request);
    }
}
