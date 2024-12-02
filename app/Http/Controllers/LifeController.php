<?php

namespace App\Http\Controllers;

use App\Repositories\SchoolSectionsRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

class LifeController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->hasView('legal')) {
            $repository = new SchoolSectionsRepository();
            return Inertia::render($repository->component(), [
                'sections' => $repository->all(),
                'course_percentage' => $user->getCoursePercentage()
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

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('role')) {
            $request->validate([
                'name' => ['required', Rule::unique('school_sections', 'name')->ignore($id)],
            ]);
            $repository = new SchoolSectionsRepository();
            $role = $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'seccion modificada correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $id)
    {
        if (auth()->user()->hasDelete('file')) {
            $repository = new SchoolSectionsRepository();
            $repository->deleteById($id);
            return redirect()->back()->with('success', 'seccion eliminada correctamente');
        }
        return $this->deny_access($request);
    }
}
