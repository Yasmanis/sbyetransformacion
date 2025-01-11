<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Repositories\FileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function getPropertiesFromFile($file)
    {
        $originalName = $file->getClientOriginalName();
        $path = $file->store('files', 'public');
        return array(
            'originalName' => $originalName,
            'path' => $path,
            'type' => mime_content_type(storage_path('app/public/' . $path)),
            'size' => filesize(storage_path('app/public/' . $path))
        );
    }

    public function index(Request $request)
    {
        if (auth()->user()->hasView('file')) {
            $repository = new FileRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            if (isset($request->sortBy)) {
                if ($request->sortBy == 'size_str') {
                    $request['sortBy'] = 'size';
                }
                $repository->orderBy($request->sortBy, $request->sortDirection);
                if ($request->sortBy == 'size') {
                    $request['sortBy'] = 'size_str';
                }
            }
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('file')) {
            if ($request->hasFile('file')) {
                $repository = new FileRepository();
                $data = $request->only((new ($repository->model()))->getFillable());
                $properties = $this->getPropertiesFromFile($request->file('file'));
                $data['name'] = $properties['originalName'];
                $data['path'] = $properties['path'];
                $data['type'] = $properties['type'];
                $data['size'] = $properties['size'];
                $data['public_access'] = $request->public_access == 'true' ? true : false;
                $repository->create($data);
            }
            return redirect()->back()->with('success', 'archivo adicionado correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('file')) {
            $repository = new FileRepository();
            $public_access = $repository->getById($id)->public_access;
            $file = $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
            if ($file->public_access != $public_access) {
                $file->public_date = $file->public_access ? $file->updated_at : null;
                $file->save();
            }
            return redirect()->back()->with('success', 'archivo modificado correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('file')) {
            $repository = new FileRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? 'archivo eliminado correctamente' : 'archivos eliminados correctamente');
        }
        return $this->deny_access($request);
    }

    public function download(Request $request, $id)
    {
        $file = File::find($id);
        return Storage::download(public_path() . '/storage/' . $file->path);
    }

    public function poster(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('file')) {
            $file = File::find($id);
            $has_poster = isset($file->poster);
            $msg = 'portada agregada correctamente';
            if ($request->hasFile('poster')) {
                if ($has_poster) {
                    $file->deletePosterFromDisk();
                    $msg = 'portada cambiada correctamente';
                }
                $path = $request->file('poster')->store('files/poster', 'public');
                $file->poster = $path;
            } else {
                if ($has_poster) {
                    $file->poster = null;
                    $file->deletePosterFromDisk();
                    $msg = 'portada eliminada correctamente';
                }
            }
            $file->save();
            return redirect()->back()->with('success', $msg);
        }
        return $this->deny_access($request);
    }

    public function publicAccess(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('file')) {
            $file = File::find($id);
            $file->public_access = !$file->public_access;
            $file->save();
            $file->public_date = $file->public_access ? $file->updated_at : null;
            $file->save();
            return redirect()->back()->with('success', $file->public_access ? 'se ha pasado el archivo al acceso publico correctamente' : 'se ha quitado el archivo del acceso publico correctamente');
        }
        return $this->deny_access($request);
    }
}
