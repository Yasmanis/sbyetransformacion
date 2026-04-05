<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\User;
use App\Models\UserLastCourse;
use App\Repositories\BuyerRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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

    public function create(Request $request)
    {
        if (auth()->user()->hasCreate('user')) {
            return Inertia('users/card');
        }
        return $this->deny_access($request);
    }

    public function show(Request $request, $id)
    {
        if (auth()->user()->hasView('user')) {
            $repository = new UserRepository();
            $user = $repository->getById($id);
            $buyer = Buyer::firstWhere('user_id', $id);
            return Inertia('users/card', ['user' => $user, 'buyer' => $buyer]);
        }
        return $this->deny_access($request);
    }

    public function calendar(Request $request, $id)
    {
        if (auth()->user()->hasView('user')) {
            $repository = new UserRepository();
            $user = $repository->getById($id);
            return Inertia('users/calendar', ['user' => $user]);
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
                'country_id' => ['required'],
                'province' => ['required'],
                'genre' => ['required'],
                'birthdate' => ['required'],
            ]);
            $repository = new UserRepository();
            $user = $repository->create($request->only((new ($repository->model()))->getFillable()));
            if (isset($request->roles)) {
                $user->roles()->sync($request->roles);
            }
            if (isset($request->permissions)) {
                $user->permissions()->sync($request->permissions);
            }
            $repository = new BuyerRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            $data['birthdate']=Carbon::createFromFormat('d/m/Y', $data['birthdate']);
            $data['user_id'] = $user->id;
            $repository->create($data);
            if ($request->toList) {
                return redirect('/admin/users')->with('success', 'usuario adicionado correctamente');
            }
            return redirect('/admin/users/' . $user->id)->with('success', 'usuario adicionado correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        if ($user->hasUpdate('user')) {
            $request->validate([
                'name' => ['required'],
                'surname' => ['required'],
                'country_id' => ['required'],
                'province' => ['required'],
                'genre' => ['required'],
                'birthdate' => ['required'],
                'username' => ['required', Rule::unique('users', 'username')->ignore($id)],
                'email' => ['required', Rule::unique('users', 'email')->ignore($id)],
            ]);
            $repository = new UserRepository();
            $user = $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
            $repository = new BuyerRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            $data['birthdate']=Carbon::createFromFormat('d/m/Y', $data['birthdate']);
            $buyer = $repository->getByColumn($id, 'user_id');
            if ($buyer) {
                $repository->updateById($buyer->id, $data);
            } else {
                $data['user_id'] = $id;
                $repository->create($data);
            }
            if (isset($request->roles)) {
                $user->roles()->sync($request->roles);
            } else {
                $user->roles()->detach();
            }
            // if (isset($request->permissions)) {
            //     $user->permissions()->sync($request->permissions);
            // } else {
            //     $user->permissions()->detach();
            // }
            if ($request->toList) {
                return redirect('/admin/users')->with('success', 'usuario modificado correctamente');
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
            return redirect('/admin/users')->with('success', count($ids) == 1 ? 'usuario eliminado correctamente' : 'usuarios eliminados correctamente');
        }
        return $this->deny_access($request);
    }

    public function lockUnlock(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('user')) {
            $user = User::find($id);
            if ($user->username === 'sa' && $user->active) {
                return redirect()->back()->with('error', 'este usuario no puede ser dado de baja');
            }
            $user->active = !$user->active;
            $user->save();
            return redirect()->back()->with('success', $user->active ? 'usuario dado de alta correctamente' : 'usuario dado de baja correctamente');
        }
        return $this->deny_access($request);
    }

    public function changePassword(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('user')) {
            $user = User::find($id);
            $user->password = Hash::make($request->password);
            $user->save();
            $request->session()->regenerate();
            return redirect()->back()->with('success', 'contraseña cambiada correctamente');
        }
        return $this->deny_access($request);
    }

    public function changeMyPassword(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'password' => 'required',
            'old_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    return $fail('contraseña actual incorrecta');
                }
            }]
        ]);
        $user->password = Hash::make($request->password);
        $user->save();
        $request->session()->regenerate();
        return redirect()->back()->with('success', 'contraseña cambiada correctamente');
    }

    public function changeTheme(Request $request)
    {
        $user = auth()->user();
        $config = $user->configuration;
        $config['dark'] = $request->dark;
        $user->configuration = $config;
        $user->save();
        return redirect()->back()->with('success', 'se ha ' . ($request->dark ? 'activado' : 'desactivado') . ' el modo oscuro correctamente');
    }

    // public function progressByTopic(Request $request, $id)
    // {
    //     if (auth()->user()->hasView('user')) {
    //         $user = User::find($id);
    //         return redirect()->back()->with('success', 'usuario modificado correctamente');
    //     }
    //     return $this->deny_access($request);
    // }

    public function progress(Request $request, $id)
    {
        $user = User::find($id);
        return response()->json([
            'sections' => $user->getTopicsBySection($request->section)
        ]);
    }

    public function comments(Request $request, $id)
    {
        $user = User::find($id);
        return response()->json($user->getComments());
    }

    public function updateLastCourses(Request $request)
    {
        $user = auth()->user()->id;
        $category = $request->category;
        $section = $request->section_id;
        $topic = $request->topic_id;
        $last = UserLastCourse::where('user_id', $user)->where('category', $category)->first();
        if ($last) {
            $last->section_id = $section;
            $last->topic_id = $topic;
            $last->save();
        } else {
            $last = UserLastCourse::create([
                'category' => $category,
                'user_id' => $user,
                'section_id' => $section,
                'topic_id' => $topic
            ]);
        }
        return response()->json($last);
    }

    public function saveColors(Request $request)
    {
        $user = auth()->user();
        $config = $user->configuration;
        $config['colors'] = $request->colors;
        $user->configuration = $config;
        $user->save();
        return redirect()->back()->with('success', 'colores configurados correctamente');
    }

    public function highlighted(Request $request)
    {
        $objects = User::whereIn('id', $request->highlighs)->get();
        foreach ($objects as $obj) {
            $obj->highlighted = !$obj->highlighted;
            $obj->save();
        }
        return redirect()->back()->with('success', 'operacion realizada correctamente');
    }
}
