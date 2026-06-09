<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ItProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ItProductCategoryController extends Controller
{
    public function List()
    {
        $list = ItProductCategory::latest()->get();
        return view('backend.it_product_categories.list', compact('list'));
    }

    public function Add()
    {
        return view('backend.it_product_categories.add');
    }

    public function Store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:it_product_categories,slug',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            ItProductCategory::create([
                'name'   => $request->name,
                'slug'   => Str::slug($request->slug),
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()
                ->route('backend.it_categories.list')
                ->with(['message' => 'IT Category created successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('IT Category Store Error: ' . $e->getMessage());
            return back()->with(['message' => 'Failed to create IT Category.', 'alert-type' => 'error'])->withInput();
        }
    }

    public function Edit($id)
    {
        $info = ItProductCategory::findOrFail($id);
        return view('backend.it_product_categories.edit', compact('info'));
    }

    public function Update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'     => 'required|exists:it_product_categories,id',
            'name'   => 'required|string|max:255',
            'slug'   => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $category = ItProductCategory::findOrFail($request->id);

        $slugExists = ItProductCategory::where('slug', Str::slug($request->slug))
            ->where('id', '!=', $category->id)
            ->exists();

        if ($slugExists) {
            return back()->withErrors(['slug' => 'This slug is already taken.'])->withInput();
        }

        try {
            DB::beginTransaction();

            $category->update([
                'name'   => $request->name,
                'slug'   => Str::slug($request->slug),
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()
                ->route('backend.it_categories.list')
                ->with(['message' => 'IT Category updated successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('IT Category Update Error: ' . $e->getMessage());
            return back()->with(['message' => 'Failed to update IT Category.', 'alert-type' => 'error'])->withInput();
        }
    }

    public function Delete($id)
    {
        try {
            ItProductCategory::findOrFail($id)->delete();

            return redirect()
                ->route('backend.it_categories.list')
                ->with(['message' => 'IT Category deleted successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            Log::error('IT Category Delete Error: ' . $e->getMessage());
            return back()->with(['message' => 'Failed to delete IT Category.', 'alert-type' => 'error']);
        }
    }
}
