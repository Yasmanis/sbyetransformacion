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
    public function index(Request $request, $id)
    {
        $documents = Document::accessibleBy($id)->get();
        return response()->json($documents);
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

    public function move(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('user')) {
            $target = Document::findOrFail($request->target_id);
            $newParentId = $request->parent_id;
            $document = Document::find($id);
            DB::transaction(function () use ($document, $target, $newParentId, $request) {
                // 1. Si cambia de carpeta, actualizamos el parent_id pero sin disparar 
                // lógicas pesadas aún, solo guardamos el cambio de relación.
                if ($document->parent_id !== $newParentId) {
                    $document->parent_id = $newParentId;
                    $document->save();
                    // Refrescamos para que la librería sepa que ahora pertenece a otro "grupo" (buildSortQuery)
                    $document->refresh();
                }

                // 2. Aplicar el reordenamiento
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

        // 2. Verificar existencia física del archivo
        if (!Storage::disk('public')->exists($document->path)) {
            abort(404, 'Archivo no encontrado en el servidor.');
        }

        // OPCIÓN A: Forzar descarga
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
