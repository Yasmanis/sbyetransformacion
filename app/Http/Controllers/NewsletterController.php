<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsletterController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('newsletter')) {
            return Inertia::render('newsletter/index');
        }
        return $this->deny_access($request);
    }
}
