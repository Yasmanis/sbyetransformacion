<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Repositories\PublicationSubcategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PublicationSubcategoryController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasView('publicationsubcategory')) {
            $repository = new PublicationSubcategoryRepository();
            $repository->search($request->search);
            $repository->filters($request->filters);
            $sortBy = $request->sortBy;
            $sortDirection = $request->sortDirection;
            if (!isset($sortBy)) {
                $sortBy = 'order';
                $sortDirection = 'ASC';
            }
            $repository->orderBy($sortBy, $sortDirection);
            $families = Family::with('subcategories')->get();
            return $this->data_index($repository, $request, ['*'], [
                'families' => $families
            ]);
        }
        return $this->deny_access($request);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasCreate('publicationsubcategory')) {
            $request->validate([
                'name' => [
                    'required',
                    Rule::unique('publication_subcategories')->where('category_id', $request->category_id)
                ],
            ]);
            $repository = new PublicationSubcategoryRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            $obj = $repository->create($data);
            if (isset($request->families_id)) {
                $obj->families()->attach($request->families_id);
            }
            return redirect()->back()->with('success', 'subcategoria adicionada correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('publicationsubcategory')) {
            $request->validate([
                'name' => ['required', Rule::unique('publication_subcategories')->where('category_id', $request->category_id)->ignore($id)],
            ]);
            $repository = new PublicationSubcategoryRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            $obj = $repository->updateById($id, $data);
            if (isset($request->families_id)) {
                $obj->families()->sync($request->families_id);
            } else {
                $obj->families()->detach();
            }
            return redirect()->back()->with('success', 'subcategoria modificada correctamente');
        }
        return $this->deny_access($request);
    }

    public function destroy(Request $request, $ids)
    {
        if (auth()->user()->hasDelete('publicationsubcategory')) {
            $repository = new PublicationSubcategoryRepository();
            $ids = explode(',', $ids);
            if (count($ids) == 1) {
                $repository->deleteById($ids[0]);
            } else {
                $repository->deleteMultipleById($ids);
            }
            return redirect()->back()->with('success', count($ids) == 1 ? 'subcategoria eliminada correctamente' : 'subcategorias eliminadas correctamente');
        }
        return $this->deny_access($request);
    }
}
