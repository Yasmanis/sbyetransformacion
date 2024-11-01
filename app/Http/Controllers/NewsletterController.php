<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Repositories\FileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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
