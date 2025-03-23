<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use App\Models\UserNotifications;
use App\Notifications\StandardNotification;
use App\Repositories\ContactRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Pusher\PushNotifications\PushNotifications;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function login()
    {
        return Inertia('auth/login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials, $request->rememberme)) {
            $user = auth()->user();
            if ($user->active) {
                $request->session()->regenerate();
                auth()->login($user);
                return redirect()->intended('admin')->with([
                    'success' => 'bienvenido ' . $user->username,
                    'show_msg_subscription' => !$user->subscripted
                ]);
            }
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return back()->with('error', 'su cuenta ha sido bloqueda, consulte a su administrador');
        }
        return back()->with('error', 'correo o contraseña incorrecta');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function getPassword(Request $request)
    {
        $user = User::firstWhere('email', $request->email);
        if ($user != null) {
            $users = User::where('sa', true)->get();
            $pass = new UserNotifications();
            $pass->title = 'cambio de contraseña';
            $pass->priority = 'Alta';
            $pass->user_id = $user->id;
            $pass->code = 'password_change';
            $pass->model = 'User';
            $pass->model_id = $user->id;
            $pass->description = 'el usuario con correo <b>' . $request->email . '</b> ha solicitado el cambio de contraseña';
            $pass->save();
            Notification::send($users, new StandardNotification($pass));
        }
        return back()->with(['success' => 'se ha solicitado el cambio de su contraseña. espere un correo con los detalles', 'ok' => true]);
    }

    public function profile()
    {
        $books = Contact::where('user_id', auth()->user()->id)->get();
        return Inertia('auth/profile', [
            'books' => $books
        ]);
    }

    public function saveProfile(Request $request)
    {
        $id = auth()->user()->id;
        $request->validate([
            'name' => ['required'],
            'surname' => ['required'],
            'username' => ['required', Rule::unique('users', 'username')->ignore($id)],
            'email' => ['required', Rule::unique('users', 'email')->ignore($id)],
        ]);
        $repository = new UserRepository();
        $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
        return redirect()->back()->with('success', 'su información ha sido actualizada correctamente');
    }

    public function changeAvatar(Request $request)
    {
        $user = auth()->user();
        $avatar  = $request->input('avatar');
        $path = null;
        if (isset($avatar)) {
            if (preg_match('/^data:image\/(\w+);base64,/', $avatar, $matches)) {
                $imgType = $matches[1];
                $imgData = substr($avatar, strpos($avatar, ',') + 1);
            }
            $image = base64_decode($imgData);
            if (!$image) {
                return redirect()->back()->with('error', 'no se ha podido decodificar la imagen');
            }
            Storage::disk('public')->put('avatars/' . $user->id . '.' . $imgType, $image);
            $path = 'avatars/' . $user->id . '.' . $imgType;
        }
        $user->avatar = $path;
        $user->save();
        return redirect()->back()->with('success', isset($avatar) ? 'avatar cambiado correctamente' : 'avatar eliminado correctamente');
    }

    public function subscribe(Request $request)
    {
        $user = auth()->user();
        $user->subscripted = true;
        $user->save();
        return redirect()->back()->with('success', 'se ha subscrito a las notificaciones push correctamente');
    }

    public function storeNewBook(Request $request)
    {
        $user = auth()->user();
        $repository = new ContactRepository();
        $data = $request->only((new ($repository->model()))->getFillable());
        $data['user_id'] = $user->id;
        $data['book_date'] = Carbon::createFromFormat('d/m/Y', $request->book_date);
        if ($request->hasFile('ticket')) {
            $path = $request->file('ticket')->store('tickets', 'public');
            $data['ticket'] = $path;
        }
        $contact = $repository->create($data);
        return redirect()->back()->with('success', 'su nueva compra ha sido registrada correctamente. espere a que el administrador la confirme');
    }

    public function deleteNotification($ids)
    {
        $ids = explode(',', $ids);
        auth()->user()->notifications()->whereIn('id', $ids)->delete();
        return redirect()->back()->with('success', count($ids) == 1 ? 'notificacion eliminada correctamente' : 'notificaciones eliminadas correctamente');
    }

    public function readUnreadNotification($id)
    {
        $notification = auth()->user()->notifications()->firstWhere('id', $id);
        if ($notification->read()) $notification->markAsUnread();
        else $notification->markAsRead();
        return redirect()->back()->with('success', $notification->read() ? 'notificacion marcada como leida correctamente' : 'notificacion marcada como no leida correctamente');
    }

    public function markNotificationsAs(Request $request)
    {
        if ($request->read) auth()->user()->notifications()->get()->markAsRead();
        else auth()->user()->notifications()->get()->markAsUnread();
        return redirect()->back()->with('success', $request->read ? 'notificaciones marcadas como leidas correctamente' : 'notificaciones marcadas como no leidas correctamente');
    }

    public function sendNotification(Request $request)
    {
        $beamsClient = new PushNotifications(array(
            "instanceId" => "556c8ed1-ac33-4910-883f-16287ddf1ab8",
            "secretKey" => "E59B83DE274A8D03C12890A8B34599000CD80406A6963FB0E8D76D845AD443E6",
        ));

        $publishResponse = $beamsClient->publishToInterests(
            array("hello"),
            array(
                "web" => array("notification" => array(
                    "title" => "Hello",
                    "body" => "Hello, World!",
                    "deep_link" => "https://www.pusher.com",
                )),
            )
        );
    }
}
