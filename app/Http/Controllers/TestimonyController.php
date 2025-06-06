<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Testimony;
use App\Repositories\TestimonyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            $sortBy = $request->sortBy;
            $sortDirection = $request->sortDirection;
            if (!isset($sortBy)) {
                $sortBy = 'order';
                $sortDirection = 'ASC';
            }
            $repository->orderBy($sortBy, $sortDirection);
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
            if ($request->hasFile('amazon_image')) {
                $path = $request->file('amazon_image')->store('testimonies', 'public');
                $data['amazon_image'] = $path;
            }
            if ($request->hasFile('message')) {
                $path = $request->file('message')->store('testimonies', 'public');
                $data['message'] = $path;
            }
            $repository->create($data);
            return redirect()->back()->with('success', 'testimonio adicionado correctamente');
        }
        return $this->deny_access($request);
    }

    public function storeFromPublications(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $repository = new TestimonyRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            $data['user_id'] = $user->id;
            if ($request->hasFile('amazonImg')) {
                $path = $request->file('amazonImg')->store('testimonies', 'public');
                $data['amazon_image'] = $path;
            }
            if ($request->hasFile('testimonyVideo')) {
                $path = $request->file('testimonyVideo')->store('testimonies', 'public');
                $data['message'] = $path;
                $data['type'] = 'video';
                $repository->create($data);
            }
            if (isset($request->testimonyText)) {
                $repository = new TestimonyRepository();
                $data['message'] = $request->testimonyText;
                $data['type'] = 'text';
                $repository->create($data);
            }
            return redirect()->back()->with(['success' => 'revisaremos que tu testimonio cumple con la etica general y tras ello se publicara', 'exclude_flash' => true]);
        }
        return redirect()->back()->with('error', 'para agregar el testimonio debe ser usuario autenticado');
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('testimony')) {
            $request->validate([
                'title' => ['required'],
            ]);
            $repository = new TestimonyRepository();
            $object = $repository->getById($id);
            $type = $object->type;
            $data = $request->only((new ($repository->model()))->getFillable());
            $old_file = null;
            if ($request->hasFile('message') || $type == 'video') {
                $old_file = $object->message;
                if ($request->hasFile('message')) {
                    $path = $request->file('message')->store('testimonies', 'public');
                    $data['message'] = $path;
                }
            }
            $old_image = null;
            if ($request->hasFile('amazon_image') || !isset($request->amazon_image)) {
                $old_image = $object->amazon_image;
                if ($request->hasFile('amazon_image')) {
                    $path = $request->file('amazon_image')->store('testimonies', 'public');
                    $data['amazon_image'] = $path;
                }
            }
            $repository->updateById($id, $data);
            if ($old_file) {
                Storage::delete('public/' . $old_file);
            }
            if ($old_image) {
                Storage::delete('public/' . $old_image);
            }
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

    public function sort(Request $request)
    {
        if (auth()->user()->hasUpdate('testimony')) {
            $testimonies = json_decode($request->ids);
            $repository = new TestimonyRepository();
            foreach ($testimonies as $c) {
                $repository->updateById($c->id, ['order' => $c->order]);
            }
            return redirect()->back()->with('success', 'testimonios ordenados correctamente');
        }
        return $this->deny_access($request);
    }
}
