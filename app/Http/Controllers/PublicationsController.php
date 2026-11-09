<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Family;
use App\Models\File;
use App\Models\PublicationSubcategory;
use Illuminate\Http\Request;

class PublicationsController extends Controller
{
    public function index(Request $request)
    {
        // 1. Categorías para el árbol lateral
        $categories = Category::with([
            'subcategories' => fn($q) => $q->orderBy('order', 'asc'),
            'families.subcategories',
        ])->where('public_access', true)->orderBy('order', 'ASC')->get();

        $recent_files = File::publicAccess()->wherePrincipal()
            ->orderBy('public_date', 'DESC')->take(6)->get();

        // 2. Leer filtros (query params, con fallback a route params antiguos)
        $categoryId    = $request->input('category_id', $categ ?? null);
        $familyId      = $request->input('family_id');
        $subcategoryId = $request->input('subcategory_id', $subcateg ?? null);

        $currentCategory    = null;
        $currentFamily      = null;
        $currentSubcategory = null;
        $activeFilter       = null;

        // 3. Resolver contexto + query base según el filtro activo
        $queryFiles = File::query()->publicAccess()->wherePrincipal();

        if ($subcategoryId) {
            // ── Filtro por SUBCATEGORÍA ──
            $currentSubcategory = PublicationSubcategory::find($subcategoryId);
            if (!$currentSubcategory) {
                return to_route('publicaciones');
            }
            $currentCategory = $currentSubcategory->category;
            $activeFilter    = 'subcategory';

            $queryFiles->where('subcategory_id', $subcategoryId);
        } elseif ($familyId) {
            // ── Filtro por FAMILIA ──
            $currentFamily = Family::with('subcategories')->find($familyId);
            if (!$currentFamily) {
                return to_route('publicaciones');
            }
            $currentCategory = $currentFamily->category;
            $activeFilter    = 'family';

            $subIds = $currentFamily->subcategories->pluck('id');
            // Si la familia no tiene subcategorías, no debe traer nada
            $queryFiles->whereIn('subcategory_id', $subIds);
        } elseif ($categoryId) {
            // ── Filtro por CATEGORÍA ──
            $c = Category::find($categoryId);
            if (!$c || !$c->public_access) {
                return to_route('publicaciones');
            }
            $currentCategory = $c;
            $activeFilter    = 'category';

            $queryFiles->where('category_id', $c->id);
        } else {
            // ── Fallback: primera categoría pública ──
            $currentCategory = $categories->first();
            if ($currentCategory) {
                $activeFilter = 'category';
                $queryFiles->where('category_id', $currentCategory->id);
            } else {
                // No hay categorías → no hay archivos
                $queryFiles->whereRaw('1 = 0');
            }
        }

        // 4. Ordenamiento (solo si hay categoría resuelta)
        if ($currentCategory) {
            if ($currentCategory->sort_files) {
                $queryFiles->orderBy('id', $currentCategory->sort_files);
            } else {
                $queryFiles->orderBy('fixed', 'DESC')->orderBy('order', 'ASC');
            }
        }

        $files = $queryFiles->with('subcategory.families')->get();

        return Inertia('landing/publicaciones', [
            'categories'          => $categories,
            'current_category'    => $currentCategory,
            'current_family'      => $currentFamily,
            'current_subcategory' => $currentSubcategory,
            'active_filter'       => $activeFilter,
            'files'               => $files,   // ← ahora va como prop propia
            'recent_files'        => $recent_files,
            'testimonies'         => [],
            'tree'                => $this->getTree(),
        ]);
    }

    public function getTree()
    {
        $categories = Category::with(['subcategories', 'families.subcategories'])->publicAccess()->orderBy('order', 'ASC')->get();

        $treeData = $categories->map(function ($category) {
            $categoriaNode = [
                'key' => 'cat_' . $category->id,
                'label' => $category->name,
                'category_id' => $category->id,
                'level' => 0,
                'children' => [],
            ];

            foreach ($category->families as $family) {
                $familiaNode = [
                    'key' => 'fam_' . $family->id,
                    'label' => $family->name,
                    'family_id' => $family->id,
                    'level' => 1,
                    'children' => $family->subcategories->map(function ($sub) use ($family) {
                        return [
                            'key' => 'sub_' . $sub->id,
                            'label' => $sub->name,
                            'level' => 2,
                            'subcategory_id' => $sub->id,
                        ];
                    })->toArray(),
                ];
                $categoriaNode['children'][] = $familiaNode;
            }

            $subcategoriasEnFamilias = $category->families->flatMap->subcategories->pluck('id')->toArray();

            $subcategoriasDirectas = $category->subcategories->filter(function ($sub) use ($subcategoriasEnFamilias) {
                return !in_array($sub->id, $subcategoriasEnFamilias);
            });

            foreach ($subcategoriasDirectas as $sub) {
                $categoriaNode['children'][] = [
                    'key' => 'sub_' . $sub->id,
                    'label' => $sub->name,
                    'level' => 1,
                    'subcategory_id' => $sub->id,
                ];
            }

            return $categoriaNode;
        });

        return $treeData;
    }
}
