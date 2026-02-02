<?php

namespace App\Http\Controllers;

use App\Models\ContactAdmin;
use App\Models\TiketReply;
use App\Models\User;
use App\Models\UserNotifications;
use App\Notifications\StandardNotification;
use App\Repositories\TiketReplyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class TiketReplyController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'message' => ['required'],
        ]);

        $notification = auth()->user()->notifications()->firstWhere('id', $request->id);
        if ($notification) {
            $exist = ContactAdmin::find($notification->data[0]['model_id']);
            if ($exist !== null) {
                $repository = new TiketReplyRepository();
                $object = $repository->create($request->only((new ($repository->model()))->getFillable()));

                $n = new UserNotifications();
                $n->title = 'respuesta a contactos';
                $n->priority = 'Baja';
                $n->user_id = $notification->notifiable_id;
                $n->description = $object->message;
                $n->code = 'reply_contact';
                $n->model = TiketReply::class;
                $n->model_id = $object->id;
                $n->save();

                $users = User::find($exist->created_by);
                Notification::send($users, new StandardNotification($n));

                if (!$notification->read()) $notification->markAsRead();
                return redirect()->back()->with('success', 'respuesta enviada correctamente');
            }
            return redirect()->back()->with('error', 'no se ha podido responder; el tiket ya fue eliminado por el usuario');
        }

        return redirect()->back()->with('error', 'notificacion no encontrada');
    }
}
