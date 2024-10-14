<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function deny_access($request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flash('error', 'acceso denegado, debe autenticarse nuevamente');
        return to_route('login');
    }

    public function data_index($repository, $request, $columns = ['*'])
    {
        return Inertia::render($repository->component(), [
            'data' => $repository->paginate(isset($request->rowsPerPage) ? $request->rowsPerPage : 20, $columns, 'page', isset($request->page) ? $request->page : null),
            'search' => isset($request->search) ? json_decode($request->search) : null,
            'sort' => isset($request->sortBy) ? [
                'sortBy' => $request->sortBy,
                'sortDirection' => $request->sortDirection
            ] : null
        ]);
    }
}