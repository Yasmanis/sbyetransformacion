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
        if ($user->hasView($segment) || ($segment == 'school' && $user->hasPerm('full_school')) || ($segment == 'learning' && $user->hasPerm('full_learning'))) {
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
                'name' => [
                    'required',
                    Rule::unique('school_sections')->where('category', $this->segment())
                ],
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
        $repository = new SchoolSectionsRepository();
        $object = $repository->getById($id);
        $segment = $object->category;
        if (auth()->user()->hasUpdate($segment)) {
            $request->validate([
                'name' => ['required', Rule::unique('school_sections')->where('category', $segment)->ignore($id)],
            ]);
            $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'seccion modificada correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $id)
    {
        $repository = new SchoolSectionsRepository();
        $object = $repository->getById($id);
        $segment = $object->category;
        if (auth()->user()->hasDelete($segment)) {
            $repository->deleteById($id);
            return redirect()->back()->with('success', 'seccion eliminada correctamente');
        }
        return $this->deny_access($request);
    }
}
