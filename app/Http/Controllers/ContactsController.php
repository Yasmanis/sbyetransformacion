<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Repositories\ContactRepository;
use Illuminate\Http\Request;

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
        $data = $request->only((new ($repository->model()))->getFillable());
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
