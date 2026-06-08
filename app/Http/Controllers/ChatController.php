<?php

namespace App\Http\Controllers;

use App\Repositories\ChatRepository;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->hasView('schoolchat')) {
            $repository = new ChatRepository();
            $repository->search($request->search);
            $filters = $request->filters;
            if (!$user->isAnAdmin()) {
                if (isset($filters)) {
                    $filters = json_decode($filters);
                } else {
                    $filters = [];
                }
                $filters[] =
                    [
                        'name' => 'from_id',
                        'type' => 'select',
                        'value' => [$user->id]

                    ];
                $filters = json_encode($filters);
            }
            $repository->filters($filters);
            $repository->orderBy($request->sortBy, $request->sortDirection);
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('schoolchat')) {
            $repository = new ChatRepository();
            $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'mensaje modificado correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('schoolchat')) {
            $repository = new ChatRepository();
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
