<?php

namespace App\Http\Controllers;

use App\Repositories\SubtitleRepository;
use Illuminate\Http\Request;

class SubtitleController extends Controller
{
    public function store(Request $request)
    {
        $repository = new SubtitleRepository();
        $object = $repository->create($request->only((new ($repository->model()))->getFillable()));
        return redirect()->back()->with([
            'success' => 'subtitulo adicionado correctamente',
            'object' => $object
        ]);
    }

    public function update(Request $request, $id)
    {
        $repository = new SubtitleRepository();
        $object = $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
        return redirect()->back()->with([
            'success' => 'subtitulo modificado correctamente',
            'object' => $object
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $repository = new SubtitleRepository();
        $repository->deleteById($id);
        return redirect()->back()->with('success', 'subtitulo eliminado correctamente');
    }
}
