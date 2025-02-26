<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\CityCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityCategoryController extends Controller
{


    public function index()
    {
        $cityCategories = CityCategory::all();
        $data =
            [
                'cityCategories' => $cityCategories
            ];
        return view('admin.product.city-category.index', $data);
    }

    // store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'icon' => 'required|image'
        ]);

        try {
            DB::beginTransaction();
            $cityCategory = new CityCategory();
            $cityCategory->name = $request->name;
            $cityCategory->save();
            $cityCategory->addMedia($request->file('icon'))->toMediaCollection('icon');
            DB::commit();
            return redirect()->back()->with('success', 'City Category created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'City Category failed to create');
        }
    }

    // update
    public function update(Request $request, CityCategory $cityCategory)
    {
        $request->validate([
            'name' => 'required',
            'icon' => 'image'
        ]);

        try {
            DB::beginTransaction();
            $cityCategory->name = $request->name;
            $cityCategory->save();
            if ($request->hasFile('icon')) {
                $cityCategory->clearMediaCollection('icon');
                $cityCategory->addMedia($request->file('icon'))->toMediaCollection('icon');
            }
            DB::commit();
            return redirect()->back()->with('success', 'City Category updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'City Category failed to update');
        }
    }

    // destroy
    public function destroy(CityCategory $cityCategory)
    {
        try {
            DB::beginTransaction();
            $cityCategory->clearMediaCollection('icon');
            $cityCategory->delete();
            DB::commit();
            return redirect()->back()->with('success', 'City Category deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'City Category failed to delete');
        }
    }
}
