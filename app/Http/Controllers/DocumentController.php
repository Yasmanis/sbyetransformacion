<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Repositories\DocumentRepository;
use App\Traits\FileSave;
use Illuminate\Http\Request;

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

    public function destroy($ids)
    {
        $ids = explode(',', $ids);
        $repository = new DocumentRepository();
        $repository->deleteMultipleById($ids);
        return redirect()->back()->with('success', count($ids) == 1 ? 'documento/fichero eliminado correctamente' : 'documents/ficheros eliminados correctamente');
    }
}
