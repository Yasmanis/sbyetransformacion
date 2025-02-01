<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Contact;
use App\Models\Role;
use App\Repositories\ContactRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        if (!isset($user)) {
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
        if ($request->hasFile('ticket')) {
            $path = $request->file('ticket')->store('tickets', 'public');
            $data['ticket'] = $path;
        }
        $contact = $repository->create($data);
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
        $r = Role::firstWhere('name', 'like', 'Usuario');
        if ($r != null) {
            $user->roles()->syncWithoutDetaching([$r->id]);
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
