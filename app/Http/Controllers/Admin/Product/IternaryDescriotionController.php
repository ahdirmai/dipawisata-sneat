<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\IternaryDescription;
use Illuminate\Support\Facades\DB;

class IternaryDescriotionController extends Controller
{
    public function index()
    {
        $descriptions = IternaryDescription::all();
        return view('admin.product.description-iternary.index', compact('descriptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'journey_iternary' => 'required|string',
            'category' => 'required|string',
            'duration' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();
            IternaryDescription::create($request->only(['title', 'description', 'journey_iternary', 'category', 'duration']));
            DB::commit();
            return redirect()->route('admin.product.description-iternary.index')->with('success', 'Description created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.product.description-iternary.index')->with('error', 'Failed to create description.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'journey_iternary' => 'required|string',
            'category' => 'required|string',
            'duration' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();
            $description = IternaryDescription::findOrFail($id);
            $description->update($request->only(['title', 'description', 'journey_iternary', 'category', 'duration']));
            DB::commit();
            return redirect()->route('admin.product.description-iternary.index')->with('success', 'Description updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.product.description-iternary.index')->with('error', 'Failed to update description.');
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $description = IternaryDescription::findOrFail($id);
            $description->delete();
            DB::commit();
            return redirect()->route('admin.product.description-iternary.index')->with('success', 'Description deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.product.description-iternary.index')->with('error', 'Failed to delete description.');
        }
    }
}
