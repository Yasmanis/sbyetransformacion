<?php

namespace App\Http\Controllers;

use App\Models\SchoolChat;
use App\Models\SchoolChat_Attachment;
use App\Models\SchoolResource;
use App\Models\SchoolSection;
use App\Models\SchoolTopic;
use App\Models\SchoolUserVideo;
use App\Models\User;
use App\Repositories\SchoolTopicRepository;
use App\Services\BrevoService;
use Illuminate\Database\Query\Builder;
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
            $getID3 = new \getID3;
            $f = $getID3->analyze(storage_path('app/public/' . $properties['path']));
            $resource->duration_string = date('H:i:s', $f['playtime_seconds']);
            $temp = explode(':', $resource->duration_string);
            $duration_number = (int)$temp[0] * 60 * 60 + (int)$temp[1] * 60 + (int)$temp[2];
            $resource->duration_number = $duration_number;
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
        if (auth()->user()->hasCreate('schoolsection') || auth()->user()->hasUpdate('schoolsection')) {
            $request->validate([
                'name' => ['required'],
            ]);
            $repository = new SchoolTopicRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            $data['visible_after_testimony'] = $request->visible_after_testimony == 'true' ? true : false;
            $data['skip'] = $request->skip == 'true' ? true : false;
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
        if (auth()->user()->hasCreate('schoolsection') || auth()->user()->hasUpdate('schoolsection')) {
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
        if (auth()->user()->hasUpdate('schoolsection')) {
            $resource = SchoolResource::find($id);
            $principal = $resource->principal;
            $path = $resource->path;
            $topic = $resource->topic_id;
            $resource->delete();
            Storage::delete('public/' . $path);
            if ($principal) {
                $t = SchoolTopic::find($topic);
                if ($t != null) {
                    $t->description = null;
                    $t->save();
                }
            }
            return redirect()->back()->with('success', $principal ? 'video principal eliminado correctamente' : 'adjunto eliminado correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('schoolsection')) {
            $request->validate([
                'name' => ['required'],
            ]);
            $repository = new SchoolTopicRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            $data['visible_after_testimony'] = $request->visible_after_testimony == 'true' ? true : false;
            $data['skip'] = $request->skip == 'true' ? true : false;
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
        if (auth()->user()->hasUpdate('schoolsection')) {
            $repository = new SchoolTopicRepository();
            $repository->deleteById($id);
            return redirect()->back()->with('success', 'tema eliminado correctamente');
        }
        return $this->deny_access($request);
    }

    public function sortTopics(Request $request)
    {
        if (auth()->user()->hasUpdate('schoolsection')) {
            $list = json_decode($request->ids);
            foreach ($list as $l) {
                $topic = SchoolTopic::find($l->id);
                if ($topic != null) {
                    $topic->order = $l->order;
                    $topic->save();
                }
            }
            return redirect()->back()->with('success', 'temas ordenados correctamente');
        }
        return $this->deny_access($request);
    }

    public function updateVideoPercentage(Request $request)
    {
        $user = auth()->user();
        $id = $request->id;
        $video = SchoolUserVideo::where('resource_id', $id)->where('user_id', $user->id)->first();
        $resource = SchoolResource::find($id);
        $percent = $request->last_time == 0 ? 0 : (int)(($request->last_time / $request->total_time) * 100);
        if ($percent > 95) {
            $percent = 100;
        }
        if ($video == null) {
            $video = new SchoolUserVideo();
            $video->user()->associate($user);
            $video->resource()->associate($resource);
            $video->total_time = $request->total_time;
            $video->last_time = $request->last_time;
            $video->percent = $percent;
        } else if ($video->last_time < $request->last_time) {
            $video->last_time = $request->last_time;
            $video->percent = $percent;
        }
        $video->current_time = $request->last_time;
        $video->save();
        return redirect()->back()->with('loading_msg', 'actualizando porciento...');
    }

    //Chat
    public function addAttachmentToMsg(Request $request)
    {
        $attachment = new SchoolChat_Attachment();
        if ($request->hasFile('file')) {
            $properties = $this->getPropertiesFromFile($request->file('file'));
            $attachment->name = $properties['originalName'];
            $attachment->path = $properties['path'];
            $attachment->chat()->associate($request->msg);
            $attachment->save();
        }
        return $attachment;
    }

    public function addMessage(Request $request, $topic)
    {
        $user = auth()->user();
        $users = [];
        if (isset($request->replyTo)) {
            $users[] = SchoolChat::find($request->replyTo)->from->id;
        } else if ($request->to === 'todos') {
            $users = User::where('id', '!=', $user->id)->pluck('id');
        } else {
            $users = User::where('id', '!=', $user->id)->personalSbyeTransformacion()->pluck('id');
        }
        $msg = new SchoolChat();
        $msg->message = $request->message;
        $msg->from_visible = $request->publish == 'oculto' ? false : true;
        $msg->from()->associate($user);
        $msg->topic()->associate($topic);
        if (isset($request->replyTo)) {
            $msg->replyTo()->associate($request->replyTo);
        }
        $msg->save();
        $msg->users()->attach($users);
        $msg->sendNotifications(false);

        return $msg;
    }

    public function editMessage(Request $request, $id)
    {
        $msg = SchoolChat::find($id);
        $msg->message = $request->message;
        $msg->save();
        $attachments = SchoolChat_Attachment::whereNotIn('id', $request->currentAttachments)->get();
        foreach ($attachments as $a) {
            $a->delete();
        }
        $msg->sendNotifications(true);
        return $msg;
    }

    public function reactMsg($chatId)
    {
        $user = auth()->user();
        $chat = SchoolChat::find($chatId);
        $chat->reacts()->sync($user);
        return redirect()->back()->with('success', 'se ha reaccionado al mensaje correctamente');
    }

    public function highligthMsg($chatId)
    {
        $user = auth()->user();
        $chat = SchoolChat::find($chatId);
        $chat->highligths()->sync($user);
        return redirect()->back()->with('success', 'mensaje destacado correctamente');
    }

    public function deleteMsg($id)
    {
        $chat = SchoolChat::find($id);
        $chat->deleteFromUser();
        return redirect()->back()->with('success', 'mensaje eliminado correctamente');
    }

    public function clearChat($id)
    {
        $topic = SchoolTopic::find($id);
        foreach ($topic->messages as $m) {
            $m->deleteFromUser();
        }
        return redirect()->back()->with('success', 'chat limpiado correctamente');
    }
}
