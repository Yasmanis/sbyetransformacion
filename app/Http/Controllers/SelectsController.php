<?php

namespace App\Http\Controllers;

use App\Models\BillingInformation;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\CategoryNomenclature;
use App\Models\Country;
use App\Models\Module;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use App\Models\ReasonForReturn;
use App\Models\Role;
use App\Models\SchoolSection;
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

    public function provinces(Request $request)
    {
        $country = $request->get('country');
        return response()->json([
            'options' => DB::table('users_buyers')->select('province as value', 'province as label')
                ->whereNotNull('province')
                ->where('country_id', $country)->distinct()->get()
        ]);
    }

    public function cities(Request $request)
    {
        $country = $request->get('country');
        $province = $request->get('province');
        return response()->json([
            'options' => DB::table('users_buyers')->select('city as value', 'city as label')
                ->whereNotNull('city')
                ->where('country_id', $country)
                ->where('province', $province)->distinct()->get()
        ]);
    }

    public function roads(Request $request)
    {
        $country = $request->get('country');
        $province = $request->get('province');
        $city = $request->get('city');
        return response()->json([
            'options' => DB::table('users_buyers')->select('road as value', 'road as label')
                ->whereNotNull('road')
                ->where('country_id', $country)
                ->where('province', $province)
                ->where('city', $city)
                ->distinct()->get()
        ]);
    }

    public function postalCodes(Request $request)
    {
        $country = $request->get('country');
        $province = $request->get('province');
        $city = $request->get('city');
        return response()->json([
            'options' => DB::table('users_buyers')->select('postal_code as value', 'postal_code as label')
                ->whereNotNull('postal_code')
                ->where('country_id', $country)
                ->where('province', $province)
                ->where('city', $city)
                ->distinct()->get()
        ]);
    }

    public function permissions()
    {
        $permissions = DB::table('permissions')->join('modules', 'modules.id', '=', 'permissions.module_id')->select('permissions.id as value', 'permissions.label', 'modules.plural_label as module')->get();
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

    public function productCategories()
    {
        return response()->json([
            'options' => ProductCategory::select('id as value', 'name as label')->get()
        ]);
    }

    public function productCourses()
    {
        $module = Module::with('childs')->firstWhere('singular_label', 'Escuela');
        return response()->json([
            'options' => $module->childs->map(function ($item) {
                return [
                    'value' => $item->id,
                    'label' => $item->singular_label
                ];
            })
        ]);
    }

    public function chatsModules()
    {
        $categories = SchoolSection::select('category')->distinct()->get()->pluck('category');
        $modules = Module::whereIn('model', $categories)->get();
        return response()->json([
            'options' => $categories->map(function ($item) use ($modules) {
                $m = $modules->first(function ($m) use ($item) {
                    return strtolower($m->model) == strtolower($item);
                });
                return [
                    'value' => $item,
                    'label' => $m?->plural_label ?? $item
                ];
            })
        ]);
    }

    public function productSubcategories($id)
    {
        return response()->json([
            'options' => ProductSubcategory::where('category_id', $id)->select('id as value', 'name as label', 'category_id')->get()
        ]);
    }

    public function reasonsForReturn()
    {
        return response()->json([
            'options' => ReasonForReturn::select('id as value', 'name as label')->get()
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
        } else if (isset($request->roleStr)) {
            $users = $users->filterByRole($request->roleStr, 'name');
        }
        if (isset($request->regex)) {
            $users = $users->filterByRegex($request->regex);
        }
        $users = $users->get();
        foreach ($users as $u) {
            $options[] = [
                'value' => $u->id,
                'label' => $u->full_name,
                'volumes' => $u->book_volumes,
                'roles' => $u->roles
            ];
        }
        return response()->json([
            'options' => $options
        ]);
    }

    public function products()
    {
        return response()->json([
            'options' => Product::select('id as value', 'name as label')->get()
        ]);
    }

    public function models()
    {
        return response()->json([
            'options' => config('recyclables', [])
        ]);
    }
}
