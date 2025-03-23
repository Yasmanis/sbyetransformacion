<?php

namespace App\Http\Controllers;

use App\Repositories\MessageRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MessagesController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('message')) {
            $repository = new MessageRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            $repository->orderBy($request->sortBy, $request->sortDirection);
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('message')) {
            $request->validate([
                'title' => ['required'],
            ]);
            $repository = new MessageRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            if (isset($request->assigned_to) && count($request->assigned_to) > 0) {
                $data['assigned_to'] = $request->assigned_to[0];
            } else {
                $data['assigned_to'] = null;
            }
            $object = $repository->create($data);
            if (isset($request->sections_id)) {
                $object->sections()->attach($request->sections_id);
            }
            if (isset($request->users_id)) {
                $object->users()->attach($request->users_id);
            }
            return redirect()->back()->with([
                'success' => 'mensaje adicionado correctamente',
                'object' => $object->only('id', 'title')
            ]);
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('message')) {
            $request->validate([
                'title' => ['required'],
            ]);
            $repository = new MessageRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            if (isset($request->assigned_to) && count($request->assigned_to) > 0) {
                $data['assigned_to'] = $request->assigned_to[0];
            } else {
                $data['assigned_to'] = null;
            }
            $object = $repository->updateById($id, $data);
            if (isset($request->sections_id)) {
                $object->sections()->sync($request->sections_id);
            }
            if (isset($request->users_id)) {
                $object->users()->sync($request->users_id);
            }
            return redirect()->back()->with('success', 'mensaje modificado correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('message')) {
            $repository = new MessageRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? 'mensaje eliminado correctamente' : 'mensajes eliminados correctamente');
        }
        return $this->deny_access($request);
    }
}