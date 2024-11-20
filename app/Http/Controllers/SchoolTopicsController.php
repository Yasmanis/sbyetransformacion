<?php

namespace App\Http\Controllers;

use App\Models\SchoolResource;
use App\Models\SchoolSection;
use App\Repositories\SchoolTopicRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SchoolTopicsController extends Controller
{
    public function getPropertiesFromFile($file)
    {
        $originalName = $file->getClientOriginalName();
        $path = $file->store('school', 'public');
        return array(
            'originalName' => $originalName,
            'path' => $path,
            'type' => mime_content_type(storage_path('app/public/' . $path)),
            'size' => filesize(storage_path('app/public/' . $path))
        );
    }

    public function addResourceToTopic($file, $topic, $principal)
    {
        $properties = $this->getPropertiesFromFile($file);
        $resource = new SchoolResource();
        $resource->name = $properties['originalName'];
        $resource->path = $properties['path'];
        $resource->type = $properties['type'];
        $resource->principal = $principal;
        $resource->topic()->associate($topic);
        if (Str::startsWith($properties['type'], 'video/')) {
            /*$getID3 = new \getID3;
            $f = $getID3->analyze($properties['path']);
            $resource->duration_string = date('H:i:s', $f['playtime_seconds']);
            $temp = explode(':', $resource->duration_string);
            $duration_number = (int)$temp[0] * 60 * 60 + (int)$temp[1] * 60 + (int)$temp[2];
            $resource->duration_number = $duration_number;*/
        }
        $resource->save();
        if ($principal) {
            $res = SchoolResource::where('topic_id', $resource->topic->id)->where('principal', true)->where('id', '!=', $resource->id)->first();
            if ($res != null) {
                $res->delete();
            }
        }
        return $resource;
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('role')) {
            $request->validate([
                'name' => ['required'],
            ]);
            $repository = new SchoolTopicRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            if ($request->hasFile('coverImage')) {
                $properties = $this->getPropertiesFromFile($request->file('coverImage'));
                $data['coverImage'] = $properties['path'];
            }
            $topic = $repository->create($data);
            return $topic;
        }
        return $this->deny_access($request);
    }

    public function addResource(Request $request)
    {
        if (auth()->user()->hasCreate('role')) {
            $repository = new SchoolTopicRepository();
            $topic = $repository->getById($request->id);
            if ($request->hasFile('file')) {
                $this->addResourceToTopic($request->file('file'), $topic, (bool)$request->principal);
            }
            return $topic;
        }
        return $this->deny_access($request);
    }

    public function deleteResource(Request $request, $id)
    {
        if (auth()->user()->hasCreate('role')) {
            $resource = SchoolResource::find($id);
            $principal = $resource->principal;
            Storage::delete('public/' . $resource->path);
            $resource->delete();
            return redirect()->back()->with('success', $principal ? 'video principal eliminado correctamente' : 'adjunto eliminado correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('role')) {
            $request->validate([
                'name' => ['required'],
            ]);
            $repository = new SchoolTopicRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            if ($request->hasFile('coverImage')) {
                $properties = $this->getPropertiesFromFile($request->file('coverImage'));
                $data['coverImage'] = $properties['path'];
                $topic = $repository->getById($id);
                if (isset($topic->coverImage)) {
                    Storage::delete('public/' . $topic->coverImage);
                }
            } else if (!isset($request->coverImage)) {
                $topic = $repository->getById($id);
                if (isset($topic->coverImage)) {
                    Storage::delete('public/' . $topic->coverImage);
                }
            }
            $repository->updateById($id, $data);
            return redirect()->back()->with([
                'success' => 'tema modificado correctamente',
                'exclude_flash' => (bool) $request->excludeFlash
            ]);
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $id)
    {
        if (auth()->user()->hasDelete('file')) {
            $repository = new SchoolTopicRepository();
            $repository->deleteById($id);
            return redirect()->back()->with('success', 'tema eliminado correctamente');
        }
        return $this->deny_access($request);
    }
}
