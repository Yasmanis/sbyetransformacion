<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Repositories\FamilyRepository;
use App\Repositories\PublicationSubcategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FamiliesController extends Controller
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
            $hasFamilies = Family::count() > 0;
            return $this->data_index($repository, $request, ['*'], [
                'hasFamilies' => $hasFamilies
            ]);
        }
        return $this->deny_access($request);
    }

    public function getSubcategoriesFromFamily(Request $request, $familyId)
    {
        $fam = Family::find($familyId);
        return response()->json($fam->subcategories);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasUpdate('publicationsubcategory')) {
            $obj = null;
            $repository = new FamilyRepository();
            if ($request->input('family_name')) {
                $request->validate([
                    'family_name' => [
                        'required',
                        Rule::unique('family', 'name')->where('category_id', $request->category_id)
                    ],
                ], [], [
                    'family_name' => 'familia',
                ]);
                $obj = $repository->create([
                    'name' => $request->input('family_name'),
                    'category_id' => $request->category_id
                ]);
            } else {
                $obj = $repository->getById($request->input('family_id'));
            }
            if (isset($request->subcategories)) {
                $obj->subcategories()->sync($request->subcategories);
            }
            return redirect()->back()->with('success', 'familia adicionada correctamente');
        }
        return $this->deny_access($request);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasUpdate('publicationsubcategory')) {
            $request->validate([
                'name' => ['required', Rule::unique('family')->where('category_id', $request->category_id)->ignore($id)],
            ], [], [
                'name' => 'familia',
            ]);
            $repository = new FamilyRepository();
            $data = $request->only((new ($repository->model()))->getFillable());
            $obj = $repository->updateById($id, $data);
            if (isset($request->subcategories)) {
                $obj->subcategories()->sync($request->subcategories);
            } else {
                $obj->subcategories()->detach();
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
