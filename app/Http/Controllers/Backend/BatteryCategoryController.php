<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BatteryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BatteryCategoryController extends Controller
{
    /* ===== List ===== */
    public function List()
    {
        try {
            $categories = BatteryCategory::withCount('products')->latest()->get();
            return view('backend.battery_category.list', compact('categories'));
        } catch (\Throwable $e) {
            Log::error('BatteryCategoryList Error: ' . $e->getMessage());
            return back()->with(['message' => 'Failed to load categories.', 'alert-type' => 'error']);
        }
    }

    /* ===== Add Form ===== */
    public function Add()
    {
        return view('backend.battery_category.add');
    }

    /* ===== Store ===== */
    public function Store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:battery_categories,name',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            BatteryCategory::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'status' => $request->status,
            ]);

            return redirect()
                ->route('backend.battery_category.list')
                ->with(['message' => 'Battery category added!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            Log::error('BatteryCategoryStore Error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with(['message' => 'Failed to add category.', 'alert-type' => 'error']);
        }
    }

    /* ===== Edit Form ===== */
    public function Edit($id)
    {
        try {
            $category = BatteryCategory::findOrFail($id);
            return view('backend.battery_category.edit', compact('category'));
        } catch (\Throwable $e) {
            Log::error('BatteryCategoryEdit Error: ' . $e->getMessage());
            return back()->with(['message' => 'Category not found.', 'alert-type' => 'error']);
        }
    }

    /* ===== Update ===== */
    public function Update(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:battery_categories,id',
            'name' => 'required|string|max:255|unique:battery_categories,name,' . $request->category_id,
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $category = BatteryCategory::findOrFail($request->category_id);
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'status' => $request->status,
            ]);

            return back()->with(['message' => 'Battery category updated!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            Log::error('BatteryCategoryUpdate Error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with(['message' => 'Failed to update category.', 'alert-type' => 'error']);
        }
    }

    /* ===== Delete ===== */
    public function Delete($id)
    {
        try {
            BatteryCategory::findOrFail($id)->delete();
            return back()->with(['message' => 'Battery category deleted!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            Log::error('BatteryCategoryDelete Error: ' . $e->getMessage());
            return back()->with(['message' => 'Failed to delete category.', 'alert-type' => 'error']);
        }
    }
}
