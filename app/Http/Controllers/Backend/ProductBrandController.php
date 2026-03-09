<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class ProductBrandController extends Controller
{
    public function ProductBrandList()
    {
        $title = 'Product Brand';

        $product_brand_list = ProductBrand::orderBy('id', 'asc')->get();

        return view('backend.product_brand.list', compact('title', 'product_brand_list'));
    } // End Method

    public function ProductBrandAdd()
    {
        $title = 'Product Brand';

        return view('backend.product_brand.add', compact('title'));
    } // End Method

    public function ProductBrandStore(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'product_brand_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'product_brand_name' => 'required|string|max:255',
                'product_brand_slug' => 'required|string|max:255|unique:product_brands,product_brand_slug',
            ],
            [
                'product_brand_image.image' => 'Brand image must be an image file',
                'product_brand_name.required' => 'Brand name is required',
                'product_brand_slug.required' => 'Slug is required',
                'product_brand_slug.unique' => 'This slug is already used, please choose another',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $product_brand_data = new ProductBrand();
            $product_brand_data->product_brand_name = $request->product_brand_name;
            $product_brand_data->product_brand_slug = Str::slug($request->product_brand_slug, '-');

            if ($request->hasFile('product_brand_image')) {
                $file = $request->file('product_brand_image');
                $manager = new ImageManager(new Driver());
                $file_name = uniqid('product_brand_', true) . '.' . $file->getClientOriginalExtension();
                $img = $manager->read($file->getRealPath());
                $img->resize(320, 200);
                $img->save(public_path('upload/product_brand_image/') . $file_name);
                $product_brand_data->product_brand_image = $file_name;
            }

            $product_brand_data->save();

            DB::commit();

            return redirect()
                ->route('backend.product_brand.list')
                ->with([
                    'message' => 'Brand created successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            if (isset($filename) && file_exists(public_path('upload/product_brand_image/' . $filename))) {
                @unlink(public_path('upload/product_brand_image/' . $filename));
            }
            DB::rollBack();
            Log::error('Error creating Brand: ' . $e->getMessage() . $e->getLine());
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Failed to create Brand.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method

    public function ProductBrandEdit($id)
    {
        $title = 'Product Brand';

        $product_brand_info = ProductBrand::findOrFail($id);

        return view('backend.product_brand.edit', compact('title', 'product_brand_info'));
    } // End Method

    public function ProductBrandUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'product_brand_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'product_brand_name' => 'required|string|max:255',
                // 'product_brand_slug' => 'required|string|max:255|unique:product_brands,product_brand_slug',
            ],
            [
                'product_brand_image.image' => 'Brand image must be an image file',
                'product_brand_name.required' => 'Brand name is required',
                // 'product_brand_slug.required' => 'Slug is required',
                // 'product_brand_slug.unique' => 'This slug is already used, please choose another',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $product_brand_data = ProductBrand::findOrFail($request->id);
            $product_brand_data->product_brand_name = $request->product_brand_name;
            $product_brand_data->product_brand_slug = Str::slug($request->product_brand_slug, '-');

            if ($request->hasFile('product_brand_image')) {
                $oldImage = public_path('upload/product_brand_image/' . $product_brand_data->product_brand_image);
                if ($product_brand_data->product_brand_image && file_exists($oldImage)) {
                    @unlink($oldImage);
                }

                $file = $request->file('product_brand_image');
                $manager = new ImageManager(new Driver());
                $file_name = uniqid('product_brand_', true) . '.' . $file->getClientOriginalExtension();
                $img = $manager->read($file->getRealPath());
                $img->resize(440, 440);
                $img->save(public_path('upload/product_brand_image/') . $file_name);
                $product_brand_data->product_brand_image = $file_name;
            }

            $product_brand_data->save();

            DB::commit();

            return redirect()
                ->back()
                ->with([
                    'message' => 'Brand updated successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error updating Brand: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Failed to update Brand.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method

    public function ProductBrandDelete($id)
    {
        try {
            DB::beginTransaction();

            $product_brand_data = ProductBrand::findOrFail($id);

            if ($product_brand_data->product_brand_image) {
                $oldImage = public_path('upload/product_brand_image/' . $product_brand_data->product_brand_image);
                if (file_exists($oldImage)) {
                    @unlink($oldImage);
                }
            }

            $product_brand_data->delete();

            DB::commit();

            return redirect()
                ->route('backend.product_brand.list')
                ->with([
                    'message' => 'Brand deleted successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error deleting Brand: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with([
                    'message' => 'Failed to delete Brand.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method
}
