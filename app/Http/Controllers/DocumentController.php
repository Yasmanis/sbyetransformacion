<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Repositories\DocumentRepository;
use App\Traits\FileSave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    use FileSave;

    public function index()
    {
        $documents = Document::accessibleBy(auth()->id())->get();
        return inertia('documents/list', [
            'documents' => $documents
        ]);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasUpdate('user')) {
            $repository = new DocumentRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            if ($request->hasFile('file')) {
                $properties = $this->getPropertiesFromFile($request->file('file'), 'documents');
                $data['name'] = $properties['originalName'];
                $data['path'] = $properties['path'];
                $data['type'] = $properties['type'];
                $data['size'] = $properties['size'];
                if ($data['parent_id'] === 'null') {
                    $data['parent_id'] = null;
                }
            }
            $object = $repository->create($data);
            return redirect()->back()->with('success', $object->is_folder ? 'carpeta adicionada correctamente' : 'archivo adicionado correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('user')) {
            $repository = new DocumentRepository();
            $object = $repository->getById($id);
            $data = $request->only((new ($repository->model()))->getFillable());
            if (!$object->is_folder) {
                $data['name'] = sprintf('%s.%s', $data['name'], Str::afterLast($object->name, '.'));
            }
            $object = $repository->updateById($id, $data);
            return redirect()->back()->with('success', $object->is_folder ? 'carpeta modificada correctamente' : 'fichero modificado correctamente');
        }
        return $this->deny_access($request);
    }

    public function shared(Request $request, $id)
    {
        $users = $request->input('users', []);
        $document = Document::findOrFail($id);
        if (!empty($users)) {
            $document->sharedWith()->sync($users);
            return redirect()->back()->with('success', $document->is_folder ? 'carpeta compartida correctamente' : 'archivo compartido correctamente');
        }
        $document->sharedWith()->detach();
        return redirect()->back()->with('success', $document->is_folder ? 'carpeta dejada de compartir correctamente' : 'archivo dejado de compartir correctamente');
    }

    public function move(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('user')) {
            $target = Document::findOrFail($request->target_id);
            $newParentId = $request->parent_id;
            $document = Document::find($id);
            DB::transaction(function () use ($document, $target, $newParentId, $request) {
                if ($document->parent_id !== $newParentId) {
                    $document->parent_id = $newParentId;
                    $document->save();
                    $document->refresh();
                }
                if ($request->drop_position === 'before') {
                    $document->moveBefore($target);
                } elseif ($request->drop_position === 'after') {
                    $document->moveAfter($target);
                } elseif ($request->drop_position === 'inside') {
                    $document->moveToEnd();
                }
            });

            return redirect()->back()->with('success',  $document->is_folder ? 'carpeta movida correctamente' : 'fichero movido correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy($ids)
    {
        $ids = explode(',', $ids);
        $repository = new DocumentRepository();
        $repository->deleteMultipleById($ids);
        return redirect()->back()->with('success', count($ids) == 1 ? 'documento/fichero eliminado correctamente' : 'documents/ficheros eliminados correctamente');
    }

    public function download($id)
    {
        $document = Document::findOrFail($id);
        if ($document->is_folder) {
            abort(403, 'No puedes descargar una carpeta directamente.');
        }
        if (!Storage::disk('public')->exists($document->path)) {
            abort(404, 'Archivo no encontrado en el servidor.');
        }
        return Storage::disk('public')->download($document->path, $document->name);
    }

    public function open($id)
    {
        $document = Document::findOrFail($id);
        if ($document->is_folder) abort(403);
        $path = storage_path('app/public/' . $document->path);
        return response()->file($path, [
            'Content-Disposition' => 'inline; filename="' . $document->name . '"'
        ]);
    }
}
