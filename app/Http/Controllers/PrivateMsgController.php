<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\File;
use App\Models\PrivateMsg;
use App\Models\PrivateMsgReceived;
use App\Models\PrivateMsgUserNote;
use App\Repositories\CategoryRepository;
use App\Repositories\PrivateMsgRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PrivateMsgController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'title' => ['required_if:parent_id,null'],
            'msg' => ['required'],
            'users' => ['required', 'array'],
        ]);
        $repository = new PrivateMsgRepository();
        $data = $request->only((new ($repository->model()))->getFillable());
        if (isset($request->parent_id)) {
            $data['parent_id'] = $request->parent_id;
            $data['to_id'] = $request->to_id;
            $data['title'] = 'Re: ' . PrivateMsg::find($request->parent_id)->title;
            $highlight = PrivateMsg::where('to_id', $request->to_id)->where('parent_id', $request->parent_id)->orderBy('id', 'desc')->first();
            if ($highlight == null) {
                $highlight = PrivateMsg::whereHas('users', function (Builder $query) use ($request) {
                    $query->where('user_id', $request->to_id)->where('message_id', $request->parent_id)->where('highlight', true);
                })->first();
                $data['highlight_by_to'] = $highlight == null ? false : true;
            } else {
                $data['highlight_by_to'] = $highlight->highlight_by_to;
            }
        } else {
            $data['title'] = $request->title;
        }
        $msg = $repository->create($data);
        foreach ($request->users as $u) {
            if ($u != $user->id) {
                $received = new PrivateMsgReceived();
                $received->user_id = $u;
                $received->message_id=$msg->id;
                //$received->parent_id = isset($request->parent_id) ? $request->parent_id : null;
                $received->save();
            }
        }
        return redirect()->back()->with('success', 'mensaje enviado correctamente');
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('private_msg')) {
            $request->validate([
                'name' => ['required', Rule::unique('category', 'name')->ignore($id)],
            ]);
            $repository = new PrivateMsgRepository();
            $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'categoria modificada correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('private_msg')) {
            $repository = new PrivateMsgRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? 'categoria eliminada correctamente' : 'categorias eliminadas correctamente');
        }
        return $this->deny_access($request);
    }

    public function highlight($id)
    {
        $message = PrivateMsg::find($id);
        $highlight = false;
        if ($message->parent == null) {
            $pmr = PrivateMsgReceived::where('message_id', $id)->where('user_id', auth()->user()->id)->first();
            $pmr->highlight = !$pmr->highlight;
            $pmr->save();
            $highlight = $pmr->highlight;
        } else {
            $message->highlight_by_to = !$message->highlight_by_to;
            $message->save();
            $highlight = $message->highlight_by_to;
        }
        return redirect()->back()->with('success', $highlight ? 'mensaje resaltado correctamente' : 'se ha dejado de resltar el mensaje correctamente');
    }

    public function read($id)
    {
        $message = PrivateMsg::find($id);
        if ($message->parent == null) {
            $pmr = PrivateMsgReceived::where('message_id', $id)->where('user_id', auth()->user()->id)->first();
            $pmr->read = true;
            $pmr->save();
        } else {
            $message->read_by_to = true;
            $message->save();
        }
        return response()->json([
            'success' => true
        ]);
    }

    public function storeNote(Request $request)
    {
        $user_id = auth()->user()->id;
        $n = [
            'text' => $request->text,
            'tcolor' => $request->tcolor,
            'bgcolor' => $request->bgcolor,
            'object_id' => 0
        ];
        $notes = [];
        foreach ($request->ids as $id) {
            $note = PrivateMsgUserNote::where('user_id', $user_id)->where('message_id', $id)->first();
            if ($note == null) {
                $note = new PrivateMsgUserNote();
                $note->user_id = $user_id;
                $note->message_id = $id;
            }
            $n['object_id'] = $id;
            $note->note = json_encode($n);
            $note->save();
            $notes[] = $n;
        }
        return response()->json([
            'success' => true,
            'note' => $n
        ]);
    }

    public function updateNote(Request $request, $id)
    {
        $n = [
            'text' => $request->text,
            'tcolor' => $request->tcolor,
            'bgcolor' => $request->bgcolor,
            'object_id' => (int)$id
        ];
        $note = PrivateMsgUserNote::where('user_id', auth()->user()->id)->where('message_id', $id)->first();
        $note->note = json_encode($n);
        $note->save();
        return response()->json([
            'success' => true,
            'note' => $n
        ]);
    }

    public function deleteNote(Request $request, $id)
    {
        $note = PrivateMsgUserNote::where('user_id', auth()->user()->id)->where('message_id', $id)->first();
        $note->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function archive(Request $request)
    {
        $user = auth()->user();
        foreach ($request->messages as $m) {
            if ($request->archive) {
                $user->archived_private_msg()->attach($m);
            } else {
                $user->archived_private_msg()->detach($m);
            }
        }
        return response()->json([
            'success' => true
        ]);
    }

    public function download($attachmentId)
    {
        $attachment = PrivateMsgAttachments::find($attachmentId);
        return Storage::download('public/' . $attachment->path, $attachment->name);
    }
}
