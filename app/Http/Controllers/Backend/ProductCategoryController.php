<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function ProductCategoriesList()
    {
        $product_categories_list = ProductCategory::latest()->get();
        return view('backend.product_categories.list', compact('product_categories_list'));
    } // End Method

    public function ProductCategoriesAdd()
    {
        return view('backend.product_categories.add');
    } // End Method

    public function ProductCategoriesStore(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'product_category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'product_category_name' => 'required|string|max:255',
                'product_category_slug' => 'required|string|max:255|unique:product_categories,product_category_slug',
            ],
            [
                'product_category_image.image' => 'Product Category image must be an image file',
                'product_category_name.required' => 'Product Category name is required',
                'product_category_slug.required' => 'Slug is required',
                'product_category_slug.unique' => 'This slug is already used, please choose another',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $product_category_data = new ProductCategory();
            $product_category_data->product_category_name = $request->product_category_name;
            $product_category_data->product_category_slug = Str::slug($request->product_category_slug, '-');

            if ($request->hasFile('product_category_image')) {
                $file = $request->file('product_category_image');
                $manager = new ImageManager(new Driver());
                $file_name = uniqid('product_category_', true) . '.' . $file->getClientOriginalExtension();
                $img = $manager->read($file->getRealPath());
                $img->resize(440, 440);
                $img->save(public_path('upload/product_category_image/') . $file_name);
                $product_category_data->product_category_image = $file_name;
            }

            $product_category_data->save();

            DB::commit();

            return redirect()
                ->route('backend.product_categories.list')
                ->with([
                    'message' => 'Product Category created successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            if (isset($filename) && file_exists(public_path('upload/product_category_image/' . $filename))) {
                @unlink(public_path('upload/product_category_image/' . $filename));
            }
            DB::rollBack();
            Log::error('Error creating Product Category: ' . $e->getMessage() . $e->getLine());
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Failed to create Product Category.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method

    public function ProductCategoriesEdit($id)
    {
        $product_categories_info = ProductCategory::findOrFail($id);
        return view('backend.product_categories.edit', compact('product_categories_info'));
    } // End Method

    public function ProductCategoriesUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'product_category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'product_category_name' => 'required|string|max:255',
                // 'product_category_slug' => 'required|string|max:255|unique:product_categories,product_category_slug',
            ],
            [
                'product_category_image.image' => 'Product Category image must be an image file',
                'product_category_name.required' => 'Product Category name is required',
                'product_category_slug.required' => 'Slug is required',
                'product_category_slug.unique' => 'This slug is already used, please choose another',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $product_categories_data = ProductCategory::findOrFail($request->id);
            $product_categories_data->product_category_name = $request->product_category_name;
            $product_categories_data->product_category_slug = Str::slug($request->product_category_slug, '-');

            if ($request->hasFile('product_category_image')) {
                $oldImage = public_path('upload/product_category_image/' . $product_categories_data->product_category_image);
                if ($product_categories_data->product_category_image && file_exists($oldImage)) {
                    @unlink($oldImage);
                }

                $file = $request->file('product_category_image');
                $manager = new ImageManager(new Driver());
                $file_name = uniqid('product_category_', true) . '.' . $file->getClientOriginalExtension();
                $img = $manager->read($file->getRealPath());
                $img->resize(440, 440);
                $img->save(public_path('upload/product_category_image/') . $file_name);
                $product_categories_data->product_category_image = $file_name;
            }

            $product_categories_data->save();

            DB::commit();

            return redirect()
                ->back()
                ->with([
                    'message' => 'Product Category updated successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error updating Product Category: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Failed to update Product Category.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method

    public function ProductCategoriesDelete($id)
    {
        try {
            DB::beginTransaction();

            $product_categories_data = ProductCategory::findOrFail($id);

            if ($product_categories_data->product_category_image) {
                $oldImage = public_path('upload/product_category_image/' . $product_categories_data->product_category_image);
                if (file_exists($oldImage)) {
                    @unlink($oldImage);
                }
            }

            $product_categories_data->delete();

            DB::commit();

            return redirect()
                ->route('backend.product_categories.list')
                ->with([
                    'message' => 'Product Category deleted successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error deleting Product Category: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with([
                    'message' => 'Failed to delete Product Category.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method
}
