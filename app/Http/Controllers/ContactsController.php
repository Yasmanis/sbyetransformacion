<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Contact;
use App\Models\ContactAdmin;
use App\Models\Role;
use App\Models\User;
use App\Models\UserNotifications;
use App\Notifications\StandardNotification;
use App\Repositories\ContactRepository;
use App\Repositories\UserRepository;
use App\Services\BrevoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Nette\Utils\Arrays;
use Spatie\Permission\Models\Permission;

class ContactsController extends Controller
{
    public function getPropertiesFromFile($file)
    {
        $originalName = $file->getClientOriginalName();
        $path = $file->store('contacts', 'public');
        return array(
            'originalName' => $originalName,
            'path' => $path,
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'surname' => ['required'],
            'email' => ['required', 'email'],
        ]);
        $repository = new ContactRepository();
        $userRepository = new UserRepository();
        $user = $userRepository->getByColumn($request->email, 'email');
        $existUser = true;
        if (!isset($user)) {
            $existUser = false;
            $data = $request->only('name', 'surname', 'email');
            $data['username'] = $request->email;
            $data['password'] = $request->email;
            $data['active'] = false;
            $user = $userRepository->create($data);
            $p = Permission::firstWhere('name', 'add_testimony');
            if ($p) {
                $user->givePermissionTo($p);
                $user->save();
            }
        }
        $data = $request->only((new ($repository->model()))->getFillable());
        $data['user_id'] = $user->id;
        $hasTicket = false;
        if ($request->hasFile('ticket')) {
            $path = $request->file('ticket')->store('tickets', 'public');
            $data['ticket'] = $path;
            $hasTicket = true;
        }
        $contact = $repository->create($data);

        $c = ContactAdmin::create([
            'subject' => $contact->msg_title,
            'description' => $contact->message,
            'created_by' => $user->id
        ]);
        $c->setMessage();

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $properties = $this->getPropertiesFromFile($file);
                Attachment::create([
                    'contact_id' => $contact->id,
                    'name' => $properties['originalName'],
                    'path' => $properties['path'],
                ]);
            }
        }
        $r = Role::firstWhere('name', 'like', $hasTicket ? 'Usuario' : 'contacto');
        if ($r != null) {
            $user->roles()->syncWithoutDetaching([$r->id]);
        }

        try {
            $notification = new UserNotifications();
            $notification->title = $existUser ? 'interaccion desde contactame' : 'nuevo usuario desde contactame';
            $notification->priority = 'Media';
            $notification->user_id = auth()?->user()?->id ?? null;
            $notification->description = $existUser ? sprintf('el usuario %s con correo %s ha interactuado desde contactame en la web', $user->full_name, $user->email) : sprintf('se ha creado desde contactame el usuario %s con correo %s como %s', $user->full_name, $user->email, $hasTicket ? 'usuario' : 'contacto');

            $users = User::where('id', 1)->get();

            $notification->code = 'contact_web_writter';
            $notification->model = 'SchoolChat';
            $notification->model_id = $contact->id;
            $notification->save();
            Notification::send($users, new StandardNotification(
                $notification,
                'AVISO - nuevo usuario',
                'admin.contacts',
                ['database', 'brevo'],
                [
                    'email' => $user->email,
                    'name' => $user->full_name,
                ]
            ));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }

        return redirect()->back()->with('success', 'su informacion ha sido registrada correctamente');
    }

    public function changeBookVolume(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('user')) {
            $word = 'cambiado(s)';
            $contact = Contact::find($id);
            if (isset($contact->book_volumes) && !isset($request->book_volumes)) {
                $word = 'desasignado(s)';
            } else if (!isset($contact->book_volumes) && isset($request->book_volumes)) {
                $word = 'asignado(s)';
            }
            $contact->book_volumes = $request->book_volumes;
            $contact->save();
            $book_volumes = DB::table('contacts')->where('user_id', $contact->user_id)->whereNotNull('book_volumes')->select('book_volumes')->distinct()->get()->pluck('book_volumes');
            $volumes = [];
            foreach ($book_volumes as $bv) {
                foreach (json_decode($bv) as $b) {
                    if (!Arrays::contains($volumes, $b)) {
                        $volumes[] = $b;
                    }
                }
            }
            $user = $contact->user;
            $user->book_volumes = count($volumes) ? $volumes : null;
            $user->save();
            return redirect()->back()->with('success', 'tomo(s) ' . $word . ' correctamente');
        }
        return $this->deny_access($request);
    }
}
