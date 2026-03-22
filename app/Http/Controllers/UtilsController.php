<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Repositories\NoteRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UtilsController extends Controller
{
    public function highlight(Request $request)
    {
        $model = $request->model ?? null;
        $highlights = $request->highlights ?? [];
        if ($model && !empty($highlights)) {
            $modelClass = "App\\Models\\" . $model;
            if (!class_exists($modelClass)) {
                return redirect()->back()->with('error', 'el modelo especificado no es valido');
            }
            $model = app()->make($modelClass);
            if (!$model instanceof Model) {
                return redirect()->back()->with('error', 'el modelo especificado no es valido');
            }
            $model::whereIn('id', $highlights)->update([
                'highlighted' => $request->state
            ]);

            return redirect()->back()->with('success', sprintf('%s(s) resaltado(s) correctamente', Str::lower($request->label) ?? 'objeto(s)'));
        }
    }
}
