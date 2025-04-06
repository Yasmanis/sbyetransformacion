<?php

namespace App\Http\Controllers;

use App\Models\PushMessageConfigNotification;
use App\Models\PushMessageFixedUser;
use Illuminate\Http\Request;
use App\Repositories\PushMessageRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Inertia;

class BriefIdeasController extends PushMessageController
{
    public function segment()
    {
        return 'briefidea';
    }

    public function index(Request $request)
    {
        if (auth()->user()->hasView($this->segment())) {
            $repository = new PushMessageRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            $sortBy = $request->sortBy;
            $sortDirection = $request->sortDirection;
            $data = [];
            if (empty($sortBy)) {
                $data = $repository->get()->sortByDesc('is_fixed')->values();
            } else {
                $repository->orderBy($sortBy, $sortDirection);
            }
            return Inertia::render($repository->component(), [
                'data' => !empty($sortBy) ? $repository->paginate(
                    isset($request->rowsPerPage) ? $request->rowsPerPage : 20,
                    ['*'],
                    'page',
                    isset($request->page) ? $request->page : null
                ) : new LengthAwarePaginator(
                    $data,
                    $repository->count(),
                    isset($request->rowsPerPage) ? $request->rowsPerPage : 20,
                    isset($request->page) ? $request->page : null
                ),
                'search' => isset($request->search) ? json_decode($request->search) : null,
                'filters' => isset($request->filters) ? json_decode($request->filters) : null,
                'sort' => isset($request->sortBy) ? [
                    'sortBy' => $request->sortBy,
                    'sortDirection' => $request->sortDirection
                ] : null
            ]);
        }
        return $this->deny_access($request);
    }

    public function fixed(Request $request, $id)
    {
        $user = auth()->user();
        $object = PushMessageFixedUser::where('user_id', $user->id)->where('message_id', $id)->first();
        if ($object == null) {
            $object = PushMessageFixedUser::create([
                'user_id' => $user->id,
                'message_id' => $id,
                'fixed' => true
            ]);
        } else {
            $object->fixed = !$object->fixed;
            $object->save();
        }
        return redirect()->back()->with('success', sprintf('idea breve %s correctamente', $object->fixed ? 'fijada' : 'dejada de fijar'));
    }

    public function configNotification(Request $request, $id)
    {
        $user = auth()->user();
        $object = PushMessageConfigNotification::where('user_id', $user->id)->where('message_id', $id)->first();
        if ($object == null) {
            $object = PushMessageConfigNotification::create([
                'user_id' => $user->id,
                'message_id' => $id,
                'data' => $request->config
            ]);
        } else {
            $object->data = $request->config;
            $object->save();
        }
        return redirect()->back()->with('success', 'notificacion configurada correctamente');
    }
}
