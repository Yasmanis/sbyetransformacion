<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('post')) {
            return Inertia::render('post/index');
        }
        return $this->deny_access($request);
    }
}
