<?php

namespace App\Http\Controllers;

use App\Repositories\PushMessageRepository;
use Illuminate\Http\Request;

class PushMessageController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('role')) {
            $repository = new PushMessageRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            $repository->orderBy($request->sortBy, $request->sortDirection);
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('role')) {
            $request->validate([
                'name' => ['required'],
            ]);
            $repository = new PushMessageRepository();
            $role = $repository->create($request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'rol adicionado correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('role')) {
            $request->validate([
                'name' => ['required'],
            ]);
            $repository = new PushMessageRepository();
            $role = $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'rol modificado correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('role')) {
            $repository = new PushMessageRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? 'rol eliminado correctamente' : 'roles eliminados correctamente');
        }
        return $this->deny_access($request);
    }
}
