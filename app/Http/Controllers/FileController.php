<?php

namespace App\Http\Controllers;

use App\Repositories\FileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
        $user = auth()->user();
        if ($user->sa || $user->hasAnyPermission(['view_file', 'update_file', 'delete_file', 'add_file'])) {
            $repository = new FileRepository();
            if (isset($request->search)) {
                $search = json_decode($request->search);
                $repository->where($search->column, $search->condition, $search->query);
            }
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
        return $this->deny_access();
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'category_id' => ['required'],
        // ]);
        if ($request->hasFile('file')) {
            $properties = $this->getPropertiesFromFile($request->file('file'));
            $request['name'] = $properties['originalName'];
            $request['path'] = $properties['path'];
            $request['type'] = $properties['type'];
            $request['size'] = $properties['size'];
        }
        $repository = new FileRepository();
        $role = $repository->create($request->only((new ($repository->model()))->getFillable()));
        if (isset($request->permissions)) {
            $role->permissions()->sync($request->permissions);
        }
        return redirect()->back()->with('success', 'rol adicionado correctamente');
    }

    public function update(Request $request, $id)
    {
        $repository = new FileRepository();
        $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
        return redirect()->back()->with('success', 'categoria modificada correctamente');
    }
}