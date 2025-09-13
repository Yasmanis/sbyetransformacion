<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConfigurationController extends Controller
{
    public function legal(Request $request)
    {
        $user = auth()->user();
        if ($user->hasPerm('view_legal_configuration') || $user->hasPerm('edit_legal_configuration')) {
            return Inertia::render('configuration/legal', [
                'config' => Configuration::all()
            ]);
        }
        return $this->deny_access($request);
    }

    public function shopping(Request $request)
    {
        return Inertia::render('configuration/shopping', [
            'config' => Configuration::all()
        ]);
    }

    public function private(Request $request)
    {
        $user = auth()->user();
        if ($user->hasPerm('view_private_configuration') || $user->hasPerm('edit_private_configuration')) {
            return Inertia::render('configuration/private');
        }
        return $this->deny_access($request);
    }

    public function save(Request $request)
    {
        $user = auth()->user();
        //if ($user->hasPerm('edit_' . $request->keyName . '_configuration')) {
        $config = Configuration::where('key', $request->keyName)->first();
        if (!isset($config)) {
            $config = new Configuration();
            $config->key = $request->keyName;
        }
        $config->value = $request->keyValue;
        $config->save();
        return redirect()->back()->with('success', 'configuracion guardada correctamente');
        //}
        return $this->deny_access($request);
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        //if ($user->hasPerm('view_'.$request->keyName.'_configuration')) {
        $config = Configuration::where('key', $request->keyName)->first();
        return $config;
        //}
        return $this->deny_access($request);
    }
}
