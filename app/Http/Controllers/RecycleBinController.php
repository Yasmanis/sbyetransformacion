<?php

namespace App\Http\Controllers;

use App\Models\RecycleBin;
use App\Repositories\RecycleBinRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecycleBinController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('recyclebin')) {
            $repository = new RecycleBinRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            $repository->orderBy($request->sortBy, $request->sortDirection);
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function restore(Request $request)
    {
        if (auth()->user()->hasUpdate('recyclebin')) {
            $repository = new RecycleBinRepository();
            $ids = $request->input('ids');
            return DB::transaction(
                function () use ($repository, $ids) {
                    $restored = RecycleBin::whereIn('id', $ids)->get();
                    foreach ($restored as $d) {
                        $model = $d->recyclable_type::onlyTrashed()->find($d->recyclable_id);
                        if ($model) {
                            $model->restoreFromRecycleBin();
                        }
                    }
                    $repository->deleteMultipleById($ids);
                    return redirect()->back()->with('success', count($ids) == 1 ? 'registro restaurado correctamente' : 'registros restaurados correctamente');
                }
            );
            return redirect()->back()->with('error', 'error al realizar esta operacion');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('recyclebin')) {
            $ids = explode(',', $ids);
            RecycleBin::whereIn('id', $ids)->delete();
            return redirect()->back()->with('success', count($ids) == 1 ? 'registro eliminado correctamente' : 'registros eliminados correctamente');
        }
        return $this->deny_access($request);
    }

    public function emptyAll(Request $request)
    {
        if (auth()->user()->hasDelete('recyclebin')) {
            RecycleBin::truncate();
            return redirect()->back()->with('success', 'papelera vaciada correctamente');
        }
        return $this->deny_access($request);
    }
}
