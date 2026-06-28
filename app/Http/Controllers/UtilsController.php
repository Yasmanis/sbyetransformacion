<?php

namespace App\Http\Controllers;

use App\Models\RowConfig;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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

    public function fixed(Request $request)
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
            $object = $model::find($modelId);
            if ($object) {
                $fixed = $request->get('fixed', false);
                $object[$columnName] = $fixed;
                $object->save();
                return redirect()->back()->with('success', sprintf('objeto %s correctamente', $fixed ? 'fijado' : 'dejado de fijar'));
            }
            return redirect()->back()->with('success', 'objeto no encontrado');
        }
        return redirect()->back()->with('error', 'modelo especificado no valido');
    }

    public function sortedElements(Request $request)
    {
        $modelName = $request->modelName ?? null;
        $sortedColumns = $request->sortedColumns ?? ['id' => 'asc'];
        $parentId = $request->parentId ?? null;
        $parentColumn = $request->parentColumn ?? null;
        if ($modelName && $sortedColumns) {
            $modelClass = "App\\Models\\" . $modelName;
            if (!class_exists($modelClass)) {
                return response()->json(['rows' => [], 'success' => false, 'message' => 'modelo no encontrado']);
            }
            $model = app()->make($modelClass);
            if (!$model instanceof Model) {
                return response()->json(['rows' => [], 'success' => false, 'message' => 'modelo no encontrado']);
            }
            $objects = $model::query();
            if ($parentColumn && $parentId) {
                $objects->where($parentColumn, $parentId);
            }
            foreach ($sortedColumns as $key => $value) {
                $objects->orderBy($key, $value);
            }
            return response()->json(['rows' => $objects->get(), 'success' => true]);
        }
        return response()->json(['rows' => [], 'success' => false, 'message' => 'modelo no encontrado']);
    }

    public function sortElements(Request $request)
    {
        $modelName = $request->modelName ?? null;
        $sorteds = $request->sorteds ?? null;
        $sortColumn = $request->sortColumn ?? 'order';
        if ($modelName && $sorteds && $sortColumn) {
            $modelClass = "App\\Models\\" . $modelName;
            if (!class_exists($modelClass)) {
                return redirect()->back()->with('error', 'modelo especificado no valido');
            }
            $model = app()->make($modelClass);
            if (!$model instanceof Model) {
                return redirect()->back()->with('error', 'modelo especificado no valido');
            }
            foreach ($sorteds as $key => $value) {
                $obj = $model::find($key);
                if ($obj != null) {
                    $obj[$sortColumn] = $value;
                    $obj->save();
                }
            }
            return redirect()->back()->with('success', 'objetos ordenados correctamente');
        }
        return redirect()->back()->with('error', 'modelo especificado no valido');
    }

    public function changeDefaultOrderElements(Request $request)
    {
        $modelName = $request->modelName ?? null;
        $modelId = $request->modelId ?? null;
        $sorted = $request->sorted ?? null;
        $sortColumn = $request->sortColumn ?? 'order';
        if ($modelName && $sortColumn && $modelId) {
            $modelClass = "App\\Models\\" . $modelName;
            if (!class_exists($modelClass)) {
                return redirect()->back()->with('error', 'modelo especificado no valido');
            }
            $model = app()->make($modelClass);
            if (!$model instanceof Model) {
                return redirect()->back()->with('error', 'modelo especificado no valido');
            }
            $obj = $model::find($modelId);
            if ($obj != null) {
                $obj[$sortColumn] = $sorted;
                $obj->save();
                return redirect()->back()->with('success', 'orden cambiado correctamente');
            }
            return redirect()->back()->with('error', 'modelo especificado no valido');
        }
        return redirect()->back()->with('error', 'modelo especificado no valido');
    }
}
