<?php

namespace App\Http\Controllers;

use App\Models\ContactAdmin;
use App\Models\User;
use App\Models\UserNotifications;
use App\Notifications\StandardNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ContactAdminController extends Controller
{
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
        $notification = new UserNotifications();
        $notification->title = 'ayuda desde contacto';
        $notification->priority = 'Alta';
        $notification->user_id = auth()->user()->id;
        $notification->description = $request->description;
        $notification->code = 'help_from_contact';
        $notification->model = 'ContactAdmin';
        $notification->model_id = $contact->id;
        $notification->save();
        $users = User::isAdmin()->get();
        Notification::send($users, new StandardNotification($notification));
        return redirect()->back()->with('success', 'solicitud enviada correctamente');
    }
}
