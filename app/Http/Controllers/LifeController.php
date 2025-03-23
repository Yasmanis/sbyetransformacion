<?php

namespace App\Http\Controllers;

use App\Repositories\SchoolSectionsRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

class LifeController extends Controller
{
    public function segment()
    {
        return last(request()->segments());
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $segment = $this->segment();
        if ($user->hasView($segment)) {
            $repository = new SchoolSectionsRepository();
            return Inertia::render($repository->component(), [
                'sections' => $user->getSections($segment),
                'course_percentage' => $user->getCoursePercentage($segment),
                'private_messages' => $user->getPrivateMessages($request, 'received')
            ]);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        $segment = $this->segment();
        if (auth()->user()->hasCreate($segment)) {
            $request->validate([
                'name' => ['required', 'unique:school_sections'],
            ]);
            $repository = new SchoolSectionsRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            $data['category'] = $this->segment();
            $section = $repository->create($data);
            return $section;
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        $segment = $this->segment();
        if (auth()->user()->hasUpdate($segment)) {
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
        $segment = $this->segment();
        if (auth()->user()->hasDelete($segment)) {
            $repository = new SchoolSectionsRepository();
            $repository->deleteById($id);
            return redirect()->back()->with('success', 'seccion eliminada correctamente');
        }
        return $this->deny_access($request);
    }
}