<?php

namespace App\Http\Controllers;

use App\Repositories\CampaignRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('campaign')) {
            $repository = new CampaignRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            $repository->orderBy($request->sortBy, $request->sortDirection);
            return $this->data_index($repository, $request);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('campaign')) {
            $request->validate([
                'title' => ['required', 'unique:campaigns'],
            ]);
            $repository = new CampaignRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            if (isset($request->start_date)) {
                $data['start_date'] = Carbon::createFromFormat('d/m/Y', $request->start_date);
            }
            if (isset($request->end_date)) {
                $data['end_date'] = Carbon::createFromFormat('d/m/Y', $request->end_date);
            }
            $object = $repository->create($data);
            if (isset($request->sections)) {
                $object->sections()->attach($request->sections);
            }
            if (isset($request->users)) {
                $object->assignedTo()->attach($request->users);
            }
            return redirect()->back()->with([
                'success' => 'campaña adicionada correctamente',
                'object' => $object->only('id', 'title')
            ]);
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('campaign')) {
            $request->validate([
                'title' => ['required', Rule::unique('category', 'name')->ignore($id)],
            ]);
            $repository = new CampaignRepository();
            $repository->updateById($id, $request->only((new ($repository->model()))->getFillable()));
            return redirect()->back()->with('success', 'campaña modificada correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('campaign')) {
            $repository = new CampaignRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? 'campaña eliminada correctamente' : 'campañas eliminadas correctamente');
        }
        return $this->deny_access($request);
    }
}
