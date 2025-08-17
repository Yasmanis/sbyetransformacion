<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
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
        $request->session()->flash('error', 'usted no tiene acceso a esta solicitud. contacte a su administrador');
        return to_route('login');
    }

    public function data_index($repository, $request, $columns = ['*'], $data = null)
    {
        return Inertia::render($repository->component(), [
            'data' => $repository->paginate(isset($request->rowsPerPage) ? $request->rowsPerPage : 20, $columns, 'page', isset($request->page) ? $request->page : null),
            'search' => isset($request->search) ? json_decode($request->search) : null,
            'filters' => isset($request->filters) ? json_decode($request->filters) : null,
            'sort' => isset($request->sortBy) ? [
                'sortBy' => $request->sortBy,
                'sortDirection' => $request->sortDirection
            ] : null
        ]);
    }

    public function data_index_no_component($repository, $request, $columns = ['*'], $data = null)
    {
        return [
            'data' => $repository->paginate(isset($request->rowsPerPage) ? $request->rowsPerPage : 20, $columns, 'page', isset($request->page) ? $request->page : null),
            'search' => isset($request->search) ? json_decode($request->search) : null,
            'filters' => isset($request->filters) ? json_decode($request->filters) : null,
            'sort' => isset($request->sortBy) ? [
                'sortBy' => $request->sortBy,
                'sortDirection' => $request->sortDirection
            ] : null
        ];
    }
}
