<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\CategoryNomenclature;
use App\Models\City;
use App\Models\Country;
use App\Models\Role;
use App\Models\State;
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

    public function campaigns()
    {
        return response()->json([
            'options' => Campaign::select('id as value', 'title as label', 'id')->get()
        ]);
    }

    public function sections($key)
    {
        return response()->json([
            'options' => CategoryNomenclature::where('key', $key)->select('id as value', 'value as label')->get()
        ]);
    }

    public function countries()
    {
        return response()->json([
            'options' => Country::select('id as value', 'name as label', 'phonecode')->get()
        ]);
    }

    public function states($country)
    {
        return response()->json([
            'options' => isset($country) ? State::where('country_id', $country)->select('id as value', 'name as label')->get() : []
        ]);
    }

    public function cities($state)
    {
        return response()->json([
            'options' => isset($state) ? City::where('state_id', $state)->select('id as value', 'name as label', 'state_id', 'country_id')->get() : []
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