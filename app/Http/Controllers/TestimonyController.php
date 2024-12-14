<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Testimony;
use App\Repositories\TestimonyRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TestimonyController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->hasView('testimony')) {
            $repository = new TestimonyRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            if (!$user->sa) {
                $repository->where('user_id', '=', $user->id);
            }
            $repository->orderBy($request->sortBy, $request->sortDirection);
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->hasCreate('testimony')) {
            $request->validate([
                'title' => ['required'],
            ]);
            $repository = new TestimonyRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            $data['user_id'] = $user->id;
            if ($request->hasFile('file')) {
                $path = $request->file('file')->store('testimonies', 'public');
                $data['message'] = $path;
            }
            $repository->create($data);
            return redirect()->back()->with('success', 'testimonio adicionado correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('testimony')) {
            $request->validate([
                'title' => ['required'],
            ]);
            $repository = new TestimonyRepository();
            $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'testimonio modificado correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('testimony')) {
            $repository = new TestimonyRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? 'testimonio eliminado correctamente' : 'testimonios eliminados correctamente');
        }
        return $this->deny_access($request);
    }

    public function publicated(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('testimony')) {
            $testimony = Testimony::find($id);
            $testimony->publicated = !$testimony->publicated;
            $testimony->save();
            return redirect()->back()->with('success', $testimony->publicated ? 'testimonio pasado a acceso publico correctamente' : 'testimonio quitado del acceso publico correctamente');
        }
        return $this->deny_access($request);
    }
}
