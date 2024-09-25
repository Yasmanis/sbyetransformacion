<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->sa || $user->can('view_user')) {
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
}
