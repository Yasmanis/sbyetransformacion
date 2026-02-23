<?php

namespace App\Http\Controllers;

use App\Models\ContactAdmin;
use App\Models\ContactAdminAttachment;
use App\Models\TiketReply;
use App\Models\User;
use App\Models\UserNotifications;
use App\Notifications\StandardNotification;
use App\Traits\FileSave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class ContactAdminController extends Controller
{
    use FileSave;
    public function index()
    {
        $user = auth()->user();
        if ($user) {
            return response()->json($user->tikets()->latest()->get());
        }
        return response()->json([]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => ['required'],
            'description' => ['required'],
        ]);
        $contact = new ContactAdmin();
        $contact->subject = $request->subject;
        $contact->description = $request->description;
        $contact->save();
        $contact->setMessage();
        return response()->json(['success' => true, 'object' => $contact]);
    }

    public function addAttachment(Request $request)
    {
        if ($request->hasFile('file')) {
            $properties = $this->getPropertiesFromFile($request->file('file'), 'contacts_admin');
            $attach = new ContactAdminAttachment();
            $attach->name = $properties['originalName'];
            $attach->path = $properties['path'];
            $attach->type = $properties['type'];
            $attach->size = $properties['size'];
            $attach->contact_id = $request->id;
            $attach->save();
            return $attach;
        }
        return null;
    }

    public function download($id)
    {
        $attach = ContactAdminAttachment::find($id);
        return Storage::download('public/' . $attach->path, $attach->name);
    }

    public function reply(Request $request)
    {
        $request->validate([
            'description' => ['required'],
        ]);
        $notifiable = null;
        $exist = ContactAdmin::find($request->id);
        $target = $request->target;
        $row_id = null;
        if ($exist) {
            $id = $exist->root_parent_id ?? $exist->id;
            $noti = DB::table('notifications')
                ->whereJsonContains('data', ['model' => ContactAdmin::class])
                ->where(function ($query) use ($id) {
                    $query->whereJsonContains('data', ['model_id' => (string) $id])
                        ->orWhereJsonContains('data', ['model_id' => (int) $id]);
                })
                ->first();

            if ($target === 'notifications') {
                $target = 'tikets';
                $notifiable = $noti->notifiable_id;
                $data = json_decode($noti->data, true);
                $row_id = $data[0]['model_id'];
                $notification = auth()->user()->notifications()->firstWhere('id', $noti->id);
                if ($notification) {
                    if (!$notification->read()) $notification->markAsRead();
                }
            } else {
                $notifiable = $exist->created_by;
                $row_id = $noti->id;
                $target = 'notifications';
            }

            $object = new ContactAdmin();
            $object->subject = $exist->subject;
            $object->description = $request->description;
            $object->parent_id = $exist->id;
            $object->root_parent_id = $exist->root_parent_id ?? $exist->id;
            $object->save();

            $n = new UserNotifications();
            $n->title = sprintf('se le ha respondido el tiket "%s"', $exist->subject);
            $n->priority = 'Baja';
            $n->user_id = $notifiable;
            $n->description = $object->description;
            $n->code = 'reply_contact';
            $n->model = ContactAdmin::class;
            $n->model_id = $object->id;
            $n->target = $target;
            $n->row_id = $row_id;
            $n->save();
            $users = User::find($exist->created_by);
            Notification::send($users, new StandardNotification($n));
            return redirect()->back()->with('success', 'respuesta enviada correctamente');
        }
        return redirect()->back()->with('error', 'no se ha podido responder; el tiket ya fue eliminado por el usuario');
    }

    public function updateReply(Request $request, $id)
    {
        $request->validate([
            'description' => ['required'],
        ]);
        $object = ContactAdmin::find($request->id);
        $object->description = $request->description;
        $object->save();
        return redirect()->back()->with('success', 'respuesta editada correctamente');
    }

    public function destroy(Request $request)
    {
        $ids = $request->ids;
        ContactAdmin::whereIn('id', $ids)->delete();
        return redirect()->back()->with('success', count($ids) === 1 ?  'tiket eliminado correctamente' : 'tikets eliminados correctamente');
    }
}
