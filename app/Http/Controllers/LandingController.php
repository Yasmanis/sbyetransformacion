<?php

namespace App\Http\Controllers;

use App\Repositories\LandingRepository;
use App\Traits\FileSave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class LandingController extends Controller
{
    use FileSave;
    public function index(Request $request)
    {
        if (auth()->user()->hasView('landing')) {
            $repository = new LandingRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            $repository->orderBy($request->sortBy, $request->sortDirection);
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('landing')) {
            $request->validate([
                'url' => ['required', 'unique:landings'],
                'text' => ['required'],
            ]);
            $repository = new LandingRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            if ($request->hasFile('image_path')) {
                $properties = $this->getPropertiesFromFile($request->file('image_path'), 'landings');
                $data['image'] = $properties['path'];
            }
            $repository->create($data);
            return redirect()->back()->with('success', 'landing adicionada correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('landing')) {
            $request->validate([
                'url' => ['required', Rule::unique('landings', 'url')->ignore($id)],
                'text' => ['required'],
            ]);
            $repository = new LandingRepository();
            $old_file = null;
            $data = $request->only((new ($repository->model()))->getFillable());
            if ($request->hasFile('image_path')) {
                $properties = $this->getPropertiesFromFile($request->file('image_path'), 'landings');
                $data['image'] = $properties['path'];
                $object = $repository->getById($id);
                $old_file = $object->image;
            }
            $repository->updateById($id, $data);
            if ($old_file) {
                Storage::delete('public/' . $old_file);
            }
            return redirect()->back()->with('success', 'landing modificada correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('landing')) {
            $repository = new LandingRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? 'landing eliminada correctamente' : 'landings eliminadas correctamente');
        }
        return $this->deny_access($request);
    }
}
