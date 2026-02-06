<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductSubCategory;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class ProductSubCategoryController extends Controller
{
    // List
    public function ProductSubCategoriesList()
    {
        $subcategories = ProductSubCategory::latest()->with('category')->get();
        return view('backend.product_subcategories.list', compact('subcategories'));
    }

    // Add Form
    public function ProductSubCategoriesAdd()
    {
        $categories = ProductCategory::where('product_category_status', 'active')->get();
        return view('backend.product_subcategories.add', compact('categories'));
    }

    // Store
    public function ProductSubCategoriesStore(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'product_category_id' => 'required|exists:product_categories,id',
                'product_sub_category_name' => 'required|string|max:255',
                'product_sub_category_slug' => 'required|string|max:255|unique:product_sub_categories,product_sub_category_slug',
                'product_sub_category_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ],
            [
                'product_category_id.required' => 'Parent category is required',
                'product_category_id.exists' => 'Selected category does not exist',
                'product_sub_category_name.required' => 'Subcategory name is required',
                'product_sub_category_slug.required' => 'Slug is required',
                'product_sub_category_slug.unique' => 'This slug is already used, please choose another',
                'product_sub_category_image.image' => 'Subcategory image must be an image file',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $subcategory = new ProductSubCategory();
            $subcategory->product_category_id = $request->product_category_id;
            $subcategory->product_sub_category_name = $request->product_sub_category_name;
            $subcategory->product_sub_category_slug = Str::slug($request->product_sub_category_slug, '-');

            if ($request->hasFile('product_sub_category_image')) {
                $file = $request->file('product_sub_category_image');
                $manager = new ImageManager(new Driver());
                $file_name = uniqid('sub_category_', true) . '.' . $file->getClientOriginalExtension();
                $img = $manager->read($file->getRealPath());
                $img->resize(440, 440);
                $img->save(public_path('upload/product_sub_category_image/') . $file_name);
                $subcategory->product_sub_category_image = $file_name;
            }

            $subcategory->save();
            DB::commit();

            return redirect()
                ->route('backend.product_subcategories.list')
                ->with([
                    'message' => 'Subcategory created successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Subcategory Store Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Failed to create subcategory.',
                    'alert-type' => 'error',
                ]);
        }
    }

    // Edit Form
    public function ProductSubCategoriesEdit($id)
    {
        $subcategory = ProductSubCategory::findOrFail($id);
        $categories = ProductCategory::where('product_category_status', 'active')->get();
        return view('backend.product_subcategories.edit', compact('subcategory', 'categories'));
    }

    // Update
    public function ProductSubCategoriesUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'product_category_id' => 'required|exists:product_categories,id',
                'product_sub_category_name' => 'required|string|max:255',
                'product_sub_category_slug' => 'required|string|max:255|unique:product_sub_categories,product_sub_category_slug,' . $request->id,
                'product_sub_category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ],
            [
                'product_category_id.required' => 'Parent category is required',
                'product_category_id.exists' => 'Selected category does not exist',
                'product_sub_category_name.required' => 'Subcategory name is required',
                'product_sub_category_slug.required' => 'Slug is required',
                'product_sub_category_slug.unique' => 'This slug is already used, please choose another',
                'product_sub_category_image.image' => 'Subcategory image must be an image file',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $subcategory = ProductSubCategory::findOrFail($request->id);
            $subcategory->product_category_id = $request->product_category_id;
            $subcategory->product_sub_category_name = $request->product_sub_category_name;
            $subcategory->product_sub_category_slug = Str::slug($request->product_sub_category_slug, '-');

            if ($request->hasFile('product_sub_category_image')) {
                $oldImage = public_path('upload/product_sub_category_image/' . $subcategory->product_sub_category_image);
                if ($subcategory->product_sub_category_image && file_exists($oldImage)) {
                    @unlink($oldImage);
                }

                $file = $request->file('product_sub_category_image');
                $manager = new ImageManager(new Driver());
                $file_name = uniqid('sub_category_', true) . '.' . $file->getClientOriginalExtension();
                $img = $manager->read($file->getRealPath());
                $img->resize(440, 440);
                $img->save(public_path('upload/product_sub_category_image/') . $file_name);
                $subcategory->product_sub_category_image = $file_name;
            }

            $subcategory->save();
            DB::commit();

            return redirect()
                ->route('backend.product_subcategories.list')
                ->with([
                    'message' => 'Subcategory updated successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Subcategory Update Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Failed to update subcategory.',
                    'alert-type' => 'error',
                ]);
        }
    }

    // Delete
    public function ProductSubCategoriesDelete($id)
    {
        try {
            DB::beginTransaction();

            $subcategory = ProductSubCategory::findOrFail($id);

            if ($subcategory->product_sub_category_image) {
                $oldImage = public_path('upload/product_sub_category_image/' . $subcategory->product_sub_category_image);
                if (file_exists($oldImage)) {
                    @unlink($oldImage);
                }
            }

            $subcategory->delete();
            DB::commit();

            return redirect()
                ->route('backend.product_subcategories.list')
                ->with([
                    'message' => 'Subcategory deleted successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Subcategory Delete Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with([
                    'message' => 'Failed to delete subcategory.',
                    'alert-type' => 'error',
                ]);
        }
    }

    public function getByCategory(Request $request)
    {
        return ProductSubCategory::where('product_category_id', $request->category_id)->select('id', 'product_sub_category_name')->get();
    }
}
