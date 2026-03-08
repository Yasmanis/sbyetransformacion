<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Repositories\NoteRepository;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => ['required']
        ]);
        $model = $request->model ?? null;
        $notables = $request->notables ?? [];
        if ($model && !empty($notables)) {
            $notes = [];
            $repository = new NoteRepository();
            $fillables = (new ($repository->model()))->getFillable();
            $user_id = auth()->user()->id;
            $now = now()->toDateTimeString();
            $modelClass = "App\\Models\\" . $model;
            if (!class_exists($modelClass)) {
                return redirect()->back()->with('error', 'el modelo especificado no es valido');
            }
            foreach ($notables as $n) {
                $notes[] = [
                    ...$request->only($fillables),
                    'user_id' => $user_id,
                    'notable_id' => $n,
                    'notable_type' => $modelClass,
                    'created_at' => $now,
                    'updated_at' => $now
                ];
            }
            if (!empty($notes)) {
                Note::insert($notes);
                return redirect()->back()->with('success', 'nota(s) adicionada(s) correctamente');
            }
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => ['required'],
        ]);
        $repository = new NoteRepository();
        $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
        return redirect()->back()->with('success', 'nota modificada correctamente');
    }

    public function destroy($id)
    {
        $repository = new NoteRepository();
        $repository->deleteById($id);
        return redirect()->back()->with('success', 'nota eliminada correctamente');
    }
}
