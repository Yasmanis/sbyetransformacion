<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\PasswordChangeNotification;
use App\Models\User;
use App\Notifications\StandardNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\Access;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;

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
                return redirect()->intended('admin')->with('success', 'bienvenido ' . $user->username);
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
            $pass = new PasswordChangeNotification();
            $pass->title = 'cambio de contraseña';
            $pass->priority = 'Alta';
            $pass->user_id = $user->id;
            $pass->description = 'el usuario con correo <b>' . $request->email . '</b> ha solicitado el cambio de contraseña';
            $pass->save();
            Notification::send($users, new StandardNotification($pass));
        }
        return back()->with(['success' => 'se ha solicitado el cambio de su contraseña. espere un correo con los detalles', 'ok' => true]);
    }

    public function profile()
    {
        $books = Contact::where('user_id', auth()->user()->id)->orderBy('book_volume', 'ASC')->get();
        return Inertia('auth/profile', [
            'books' => $books
        ]);
    }
}