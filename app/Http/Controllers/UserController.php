<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('user')) {
            $repository = new UserRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            $repository->orderBy($request->sortBy, $request->sortDirection);
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('user')) {
            $request->validate([
                'username' => ['required', 'unique:users'],
                'email' => ['required', 'unique:users'],
                'password' => ['required', 'min:8'],
                'password_confirmed' => ['required', 'same:password'],
            ]);
            $repository = new UserRepository();
            $user = $repository->create($request->only((new ($repository->model()))->getFillable()));
            if (isset($request->roles)) {
                $user->roles()->sync($request->roles);
            }
            if (isset($request->permissions)) {
                $user->permissions()->sync($request->permissions);
            }
            return redirect()->back()->with('success', 'usuario adicionado correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('user')) {
            $request->validate([
                'email' => ['required', Rule::unique('users', 'email')->ignore($id)],
            ]);
            $repository = new UserRepository();
            $user = $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
            if (isset($request->roles)) {
                $user->roles()->sync($request->roles);
            } else {
                $user->roles()->detach();
            }
            if (isset($request->permissions)) {
                $user->permissions()->sync($request->permissions);
            } else {
                $user->permissions()->detach();
            }
            return redirect()->back()->with('success', 'usuario modificado correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('user')) {
            $repository = new UserRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? 'usuario eliminado correctamente' : 'usuarios eliminados correctamente');
        }
        return $this->deny_access($request);
    }
}