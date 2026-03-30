<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\RowConfig;
use App\Repositories\NoteRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UtilsController extends Controller
{
    public function highlight(Request $request)
    {
        $modelName = $request->modelName ?? null;
        $modelId = $request->modelId ?? null;
        $columnName = $request->columnName ?? null;
        if ($modelName && $modelId && $columnName) {
            $modelClass = "App\\Models\\" . $modelName;
            if (!class_exists($modelClass)) {
                return redirect()->back()->with('error', 'modelo especificado no valido');
            }
            $model = app()->make($modelClass);
            if (!$model instanceof Model) {
                return redirect()->back()->with('error', 'modelo especificado no valido');
            }
            $row = RowConfig::where('configable_type', $modelClass)->where('configable_id', $modelId)->first();
            if ($row) {
                $highlighteds = $row->highlighteds_columns;
                $highlighteds[$columnName] = $request->highlight;
                $row->highlighteds_columns = $highlighteds;
                $row->save();
            } else {
                RowConfig::create([
                    'configable_type' => $modelClass,
                    'configable_id' => $modelId,
                    'user_id' => auth()->user()->id,
                    'highlighteds_columns' => [
                        $columnName => $request->highlight
                    ]
                ]);
            }
            return redirect()->back()->with('success', 'columna resaltada correctamente');
        }
        return redirect()->back()->with('error', 'modelo especificado no valido');
    }

    public function removeHighlighted(Request $request)
    {
        $modelName = $request->modelName ?? null;
        $modelId = $request->modelId ?? null;
        $columnName = $request->columnName ?? null;
        if ($modelName && $modelId && $columnName) {
            $modelClass = "App\\Models\\" . $modelName;
            if (!class_exists($modelClass)) {
                return redirect()->back()->with('error', 'modelo especificado no valido');
            }
            $model = app()->make($modelClass);
            if (!$model instanceof Model) {
                return redirect()->back()->with('error', 'modelo especificado no valido');
            }
            $row = RowConfig::where('configable_type', $modelClass)->where('configable_id', $modelId)->first();
            if ($row) {
                $highlighteds = $row->highlighteds_columns;
                unset($highlighteds[$columnName]);
                $row->highlighteds_columns = $highlighteds;
                $row->save();
            }
            return redirect()->back()->with('success', 'resaltado quitado correctamente');
        }
        return redirect()->back()->with('error', 'modelo especificado no valido');
    }
}
