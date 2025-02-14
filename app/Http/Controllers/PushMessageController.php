<?php

namespace App\Http\Controllers;

use App\Repositories\PushMessageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PushMessageController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('pushmessage')) {
            $repository = new PushMessageRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            $repository->orderBy($request->sortBy, $request->sortDirection);
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('pushmessage')) {
            $repository = new PushMessageRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            if ($request->hasFile('image')) {
                $path = $request->logo->store('pushmessage', 'public');
                $data['image'] = $path;
            }
            if ($request->hasFile('video')) {
                $path = $request->logo->store('pushmessage', 'public');
                $data['video'] = $path;
            }
            $object = $repository->create($data);
            if (isset($request->sections_id)) {
                $object->sections()->attach($request->sections_id);
            }
            return redirect()->back()->with('success', 'mensaje adicionado correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('pushmessage')) {
            $repository = new PushMessageRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            $current_image = null;
            if ($request->hasFile('image')) {
                $path = $request->logo->store('pushmessage', 'public');
                $data['image'] = $path;
                $object = $repository->getById($id);
                if (isset($object->image)) {
                    $current_image = $object->image;
                }
            } else if (isset($request->image)) {
                $data['image'] = substr($request->image, strpos($request->image, 'storage') + 8);
            } else {
                $object = $repository->getById($id);
                if (isset($object->image)) {
                    $current_image = $object->image;
                }
            }
            $current_video = null;
            if ($request->hasFile('video')) {
                $path = $request->logo->store('pushmessage', 'public');
                $data['video'] = $path;
                $object = $repository->getById($id);
                if (isset($object->video)) {
                    $current_video = $object->video;
                }
            } else if (isset($request->video)) {
                $data['video'] = substr($request->video, strpos($request->video, 'storage') + 8);
            } else {
                $object = $repository->getById($id);
                if (isset($object->video)) {
                    $current_video = $object->video;
                }
            }
            $object = $repository->updateById($id, $data);
            if (isset($request->sections_id)) {
                $object->sections()->sync($request->sections_id);
            }
            if (isset($current_image)) {
                Storage::delete('public/' . $current_image);
            }
            if (isset($current_video)) {
                Storage::delete('public/' . $current_video);
            }
            return redirect()->back()->with('success', 'mensaje modificado correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('pushmessage')) {
            $repository = new PushMessageRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? 'mensaje eliminado correctamente' : 'mensajes eliminados correctamente');
        }
        return $this->deny_access($request);
    }
}
