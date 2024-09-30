<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->sa || $user->hasAnyPermission(['view_user', 'update_user', 'delete_user', 'add_user'])) {
            $repository = new UserRepository();
            if (isset($request->search)) {
                $search = json_decode($request->search);
                $repository->where($search->column, $search->condition, $search->query);
            }
            if (isset($request->sortBy)) {
                $repository->orderBy($request->sortBy, $request->sortDirection);
            }
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
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
}