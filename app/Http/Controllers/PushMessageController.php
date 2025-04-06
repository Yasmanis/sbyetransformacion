<?php

namespace App\Http\Controllers;

use App\Repositories\PushMessageRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PushMessageController extends Controller
{
    public function segment()
    {
        return 'pushmessage';
    }

    public function index(Request $request)
    {
        if (auth()->user()->hasView($this->segment())) {
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
        if (auth()->user()->hasCreate($this->segment())) {
            $repository = new PushMessageRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            if (isset($request->start_at)) {
                $data['start_at'] = Carbon::createFromFormat('d/m/Y h:i a', $request->start_at);
            }
            if (isset($request->end_at)) {
                $data['end_at'] = Carbon::createFromFormat('d/m/Y h:i a', $request->end_at);
            }
            if ($request->hasFile('logo')) {
                $path = $request->logo->store('pushmessage', 'public');
                $data['logo'] = $path;
            }
            if ($request->hasFile('image')) {
                $path = $request->image->store('pushmessage', 'public');
                $data['image'] = $path;
            }
            if ($request->hasFile('video')) {
                $path = $request->video->store('pushmessage', 'public');
                $data['video'] = $path;
            }
            $object = $repository->create($data);
            if (isset($request->sections_id)) {
                $object->sections()->attach($request->sections_id);
            }
            return redirect()->back()->with('success', sprintf('%s correctamente', $this->segment() == 'pushmessage' ? 'mensaje adicionado' : 'idea breve adicionada'));
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate($this->segment())) {
            $repository = new PushMessageRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            if (isset($request->start_at)) {
                $data['start_at'] = Carbon::createFromFormat('d/m/Y h:i a', $request->start_at);
            }
            if (isset($request->end_at)) {
                $data['end_at'] = Carbon::createFromFormat('d/m/Y h:i a', $request->end_at);
            }
            $current_image = null;
            if ($request->hasFile('image')) {
                $path = $request->image->store('pushmessage', 'public');
                $data['image'] = $path;
                $object = $repository->getById($id);
                if (isset($object->image)) {
                    $current_image = $object->image;
                }
            } else {
                unset($data['image']);
            }
            $current_video = null;
            if ($request->hasFile('video')) {
                $path = $request->video->store('pushmessage', 'public');
                $data['video'] = $path;
                $object = $repository->getById($id);
                if (isset($object->video)) {
                    $current_video = $object->video;
                }
            } else {
                unset($data['video']);
            }
            $current_logo = null;
            if ($request->hasFile('logo')) {
                $path = $request->logo->store('pushmessage', 'public');
                $data['logo'] = $path;
                $object = $repository->getById($id);
                if (isset($object->logo)) {
                    $current_logo = $object->logo;
                }
            } else {
                unset($data['logo']);
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
            if (isset($current_logo)) {
                Storage::delete('public/' . $current_logo);
            }
            return redirect()->back()->with('success', sprintf('%s correctamente', $this->segment() == 'pushmessage' ? 'mensaje modificado' : 'idea breve modificada'));
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete($this->segment())) {
            $repository = new PushMessageRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? sprintf('%s correctamente', $this->segment() == 'pushmessage' ? 'mensaje eliminado' : 'idea breve eliminada') : sprintf('%s correctamente', $this->segment() == 'pushmessage' ? 'mensajes eliminados' : 'ideas breves eliminadas'));
        }
        return $this->deny_access($request);
    }
}