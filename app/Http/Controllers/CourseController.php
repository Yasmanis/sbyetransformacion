<?php

namespace App\Http\Controllers;

use App\Models\CategoryNomenclature;
use App\Models\Module;
use App\Repositories\CourseRepository;
use App\Traits\FileSave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    use FileSave;

    public function index(Request $request)
    {
        if (auth()->user()->hasView('course')) {
            $repository = new CourseRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            $repository->orderBy($request->sortBy, $request->sortDirection);
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('course')) {
            $request->validate([
                'singular_label' => ['required', 'unique:modules'],
                'plural_label' => ['required', 'unique:modules'],
                'model' => ['required', 'unique:modules'],
            ]);
            $repository = new CourseRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            $module = Module::firstWhere('singular_label', 'Escuela');
            if ($module) {
                $data['parent_id'] = $module->id;
                $data['base_url'] = '/admin/cursos/' . $data['model'];
                if ($request->hasFile('black_image')) {
                    $dest = public_path('images/icon');

                    $file = $request->file('black_image');
                    $originalName = $file->getClientOriginalName();
                    $name = sprintf('black-%s.%s', $data['model'], Str::afterLast($originalName, '.'));
                    $path = $dest . '/' . $name;
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                    $file->move($dest, $name);

                    $file = $request->file('white_image');
                    $originalName = $file->getClientOriginalName();
                    $name = sprintf('white-%s.%s', $data['model'], Str::afterLast($originalName, '.'));
                    $path = $dest . '/' . $name;
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                    $file->move($dest, $name);
                    $data['ico'] = 'images/icon/' . $name;
                }

                $object = $repository->create($data);
                $object->setPermissions(true);

                CategoryNomenclature::create(
                    [
                        'key' => 'panels',
                        'value' => $object->plural_label
                    ]
                );

                return redirect()->back()->with('success', 'curso adicionado correctamente');
            } else {
                return redirect()->back()->with('error', 'modulo escuela no encontrado');
            }
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('course')) {
            $request->validate([
                'plural_label' => ['required', Rule::unique('modules', 'plural_label')->ignore($id)],
            ]);
            $repository = new CourseRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            if ($data['ico_from_path']) {
                unset($data['ico']);
            }
            if ($request->hasFile('black_image')) {
                $dest = public_path('images/icon');

                $file = $request->file('black_image');
                $originalName = $file->getClientOriginalName();
                $name = sprintf('black-%s.%s', $data['model'], Str::afterLast($originalName, '.'));
                $path = $dest . '/' . $name;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file->move($dest, $name);
            }
            if ($request->hasFile('white_image')) {
                $dest = public_path('images/icon');

                $file = $request->file('white_image');
                $originalName = $file->getClientOriginalName();
                $name = sprintf('white-%s.%s', $data['model'], Str::afterLast($originalName, '.'));
                $path = $dest . '/' . $name;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file->move($dest, $name);
                $data['ico'] = 'images/icon/' . $name;
            }
            $object = $repository->getById($id);
            $old_categ = $object->plural_label;
            $object->update($data);
            $object->permissions()->delete();
            $object->setPermissions(true);

            $categ = CategoryNomenclature::where('key', 'panels')->where('value', $object->plural_label)->first();
            if (!$categ) {
                CategoryNomenclature::create(
                    [
                        'key' => 'panels',
                        'value' => $object->plural_label
                    ]
                );
            }
            if ($old_categ !== $object->plural_label) {
                $categ = CategoryNomenclature::where('key', 'panels')->where('value', $old_categ)->first();
                if ($categ) {
                    $categ->delete();
                }
            }
            return redirect()->back()->with('success', 'curso modificado correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('course')) {
            $repository = new CourseRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? 'curso eliminado correctamente' : 'cursos eliminados correctamente');
        }
        return $this->deny_access($request);
    }
}
