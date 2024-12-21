<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Repositories\ContactRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
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
        return redirect()->back()->with('success', 'su informacion ha sido registrada correctamente');
    }
}
