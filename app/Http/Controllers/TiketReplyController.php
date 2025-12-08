<?php

namespace App\Http\Controllers;

use App\Repositories\TiketReplyRepository;
use Illuminate\Http\Request;

class TiketReplyController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'message' => ['required'],
        ]);
        $repository = new TiketReplyRepository();
        $repository->create($request->only((new ($repository->model()))->getFillable()));
        return redirect()->back()->with('success', 'respuesta enviada correctamente');
    }
}
