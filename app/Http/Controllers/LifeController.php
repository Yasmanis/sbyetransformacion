<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\SchoolSection;
use App\Repositories\SchoolSectionsRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class LifeController extends Controller
{
    public function segment()
    {
        return last(request()->segments());
    }

    public function code()
    {
        return $this->segment() . '_code';
    }

    public function getModule()
    {
        return Module::firstWhere('code', $this->code());
    }

    public function getSections($module)
    {
        return SchoolSection::where('module_id', $module->id)->orderBy('fixed', 'DESC')->orderBy('order', 'asc')->get();
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $segment = $this->segment();
        if ($user->hasView($segment) || ($segment == 'school' && $user->hasPerm('full_school')) || ($segment == 'learning' && $user->hasPerm('full_learning')) || ($segment == 'reality' && $user->hasPerm('full_reality'))) {
            $repository = new SchoolSectionsRepository();
            $module = $this->getModule();
            return Inertia::render($repository->component(), [
                'sections' => $this->getSections($module),
                'module' => $module,
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
            $module = Module::firstWhere('model', $this->segment());
            $request->validate([
                'name' => [
                    'required',
                    Rule::unique('school_sections')->where('module_id', $module->id)
                ],
            ]);
            $repository = new SchoolSectionsRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            $data['module_id'] = $module->id;
            $section = $repository->create($data);
            return $section;
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        $repository = new SchoolSectionsRepository();
        $object = $repository->getById($id);
        $module = $object->module;
        if (auth()->user()->hasUpdate(Str::lower($module->model))) {
            $request->validate([
                'name' => ['required', Rule::unique('school_sections')->where('module_id', $module->id)->ignore($id)],
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
        if (auth()->user()->hasDelete(Str::lower($object->module->model))) {
            $repository->deleteById($id);
            return redirect()->back()->with('success', 'seccion eliminada correctamente');
        }
        return $this->deny_access($request);
    }
}
