<?php

namespace App\Http\Controllers;

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
            return $this->data_index($repository, $request);
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
            $repository->create($data);
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
            $repository->updateById($id, $data);
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
