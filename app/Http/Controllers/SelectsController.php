<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class SelectsController extends Controller
{
    public function roles()
    {
        return response()->json([
            'options' => Role::select('id as value', 'name as label')->get()
        ]);
    }

    public function permissions()
    {
        $permissions = DB::table('permissions')->join('modules', 'modules.id', '=', 'permissions.module_id')->select('permissions.id as value', 'permissions.label', 'modules.singular_label as module')->get();
        foreach ($permissions as $p) {
            $p->label = $p->module . ' | ' . $p->label;
        }
        return response()->json([
            'options' => $permissions
        ]);
    }

    public function categories()
    {
        return response()->json([
            'options' => Category::select('id as value', 'name as label')->get()
        ]);
    }

    public function typeOfFiles()
    {
        return response()->json([
            'options' => DB::table('file')
                ->select(DB::raw('SUBSTRING_INDEX(TYPE, "/", 1) as value, SUBSTRING_INDEX(TYPE, "/", 1) label'))->distinct()->get()
        ]);
    }

    public function users(Request $request)
    {
        $options = [];
        $users = User::query();
        if (isset($request->role)) {
            $users = $users->filterByRole($request->role);
        }
        if (isset($request->regex)) {
            $users = $users->filterByRegex($request->regex);
        }
        $users = $users->get();
        foreach ($users as $u) {
            $options[] = [
                'value' => $u->id,
                'label' => $u->full_name
            ];
        }
        return response()->json([
            'options' => $options
        ]);
    }
}