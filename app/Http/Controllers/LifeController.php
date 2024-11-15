<?php

namespace App\Http\Controllers;

use App\Repositories\SchoolSectionsRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LifeController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('legal')) {
            $repository = new SchoolSectionsRepository();
            return Inertia::render($repository->component(), [
                'sections' => $repository->all()
            ]);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('role')) {
            $request->validate([
                'name' => ['required', 'unique:school_sections'],
            ]);
            $repository = new SchoolSectionsRepository();
            $section = $repository->create($request->only((new ($repository->model()))->getFillable()));
            return $section;
        }
        return $this->deny_access($request);
    }
}
