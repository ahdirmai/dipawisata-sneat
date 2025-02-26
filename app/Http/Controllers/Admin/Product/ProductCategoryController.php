<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\CategoryProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $productCategories = CategoryProduct::all();
        $data =
            [
                'productCategories' => $productCategories
            ];
        return view('admin.product.product-category.index', $data);
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
            $procutCategory = new CategoryProduct();
            $procutCategory->name = $request->name;
            $procutCategory->save();
            $procutCategory->addMedia($request->file('icon'))->toMediaCollection('icon');
            DB::commit();
            return redirect()->back()->with('success', 'Category Product created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Category Product failed to create');
        }
    }

    // update
    public function update(Request $request, CategoryProduct $productCategory)
    {
        $request->validate([
            'name' => 'required',
            'icon' => 'image'
        ]);

        try {
            DB::beginTransaction();
            $productCategory->name = $request->name;
            $productCategory->save();
            if ($request->hasFile('icon')) {
                $productCategory->clearMediaCollection('icon');
                $productCategory->addMedia($request->file('icon'))->toMediaCollection('icon');
            }
            DB::commit();
            return redirect()->back()->with('success', 'Category Product updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Category Product failed to update');
        }
    }

    // destroy
    public function destroy(CategoryProduct $productCategory)
    {
        try {
            DB::beginTransaction();
            $productCategory->clearMediaCollection('icon');
            $productCategory->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Category Product deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Category Product failed to delete');
        }
    }

    // Route::patch('/publish/{productCategory}', [ProductCategoryController::class, 'publish'])->name('togglePublish');

    // publish
    public function publish(CategoryProduct $productCategory)
    {
        // return $productCategory;
        try {
            DB::beginTransaction();
            $productCategory->is_active = !$productCategory->is_active;
            $productCategory->save();
            DB::commit();
            return redirect()->back()->with('success', 'Category Product published successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
