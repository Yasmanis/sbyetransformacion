<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModulesController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('module')) {
            return inertia('modules/list', [
                'modules' => Module::orderBy('order', 'asc')->get()
            ]);
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('module')) {
            $target = Module::findOrFail($request->target_id);
            $newParentId = $request->parent_id;
            $module = Module::find($id);
            DB::transaction(function () use ($module, $target, $newParentId, $request) {
                if ($module->parent_id !== $newParentId) {
                    $module->parent_id = $newParentId;
                    $module->save();
                    $module->refresh();
                }
                if ($request->drop_position === 'before') {
                    $module->moveBefore($target);
                } elseif ($request->drop_position === 'after') {
                    $module->moveAfter($target);
                } elseif ($request->drop_position === 'inside') {
                    $module->moveToEnd();
                }
            });
            return redirect()->back()->with('success', 'modulo desplazado correctamente');
        }
        return $this->deny_access($request);
    }
}
