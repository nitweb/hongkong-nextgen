<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AgeGroup;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductGallery;
use App\Models\ProductSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // ========== Product List ==========
    public function ProductList()
    {
        $product_list = Product::latest()
            ->with(['category', 'subcategory'])
            ->get();

        return view('backend.products.list', compact('product_list'));
    }

    // ========== Add Form ==========
    public function ProductAdd()
    {
        $categories = ProductCategory::where('product_category_status', 'active')->get();
        $subcategories = ProductSubCategory::where('product_sub_category_status', 'active')->get();
        $ageGroups = AgeGroup::orderBy('id', 'asc')->get();

        return view('backend.products.add', compact('categories', 'subcategories', 'ageGroups'));
    }

    // ========== Store ==========
    public function ProductStore(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'product_name' => 'required|string|max:255',
                'product_slug' => 'required|string|max:255|unique:products,product_slug',
                'product_category_id' => 'required|exists:product_categories,id',
                'product_sub_category_id' => 'nullable|exists:product_sub_categories,id',
                'product_price' => 'required|numeric|min:0',
                'discount_price' => 'nullable|numeric|min:0',
                'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'product_gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'age_group_id' => 'required|exists:age_groups,id',
                'test_report_astm' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
                'test_report_en71' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
                'stock_status' => 'required|in:in_stock,out_of_stock',
            ],
            [
                'product_name.required' => 'Product name is required',
                'product_slug.required' => 'Slug is required',
                'product_slug.unique' => 'Slug already exists',
                'product_category_id.required' => 'Category is required',
                'product_image.image' => 'Product image must be an image file',
                'age_group_id.required' => 'Age group is required',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            $manager = new ImageManager(new Driver());

            // Create Product
            $product = new Product();
            $product->product_name = $request->product_name;
            $product->product_slug = Str::slug($request->product_slug, '-');
            $product->product_category_id = $request->product_category_id;
            $product->product_sub_category_id = $request->product_sub_category_id;
            $product->age_group_id = $request->age_group_id;
            $product->product_price = $request->product_price;
            $product->discount_price = $request->discount_price;
            $product->product_short_description = $request->product_short_description;
            $product->product_description = $request->product_description;
            $product->product_specifications = $request->product_specifications;
            $product->is_wholesale = $request->has('is_wholesale');
            $product->is_free_delivery = $request->has('is_free_delivery');
            $product->stock_status = $request->stock_status ?? 'in_stock';
            $product->product_status = $request->product_status ?? 'active';

            // ASTM Report
            if ($request->hasFile('test_report_astm')) {
                $file = $request->file('test_report_astm');
                $fileName = uniqid('astm_', true) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/product_reports'), $fileName);
                $product->test_report_astm = $fileName;
            }

            // EN71 Report
            if ($request->hasFile('test_report_en71')) {
                $file = $request->file('test_report_en71');
                $fileName = uniqid('en71_', true) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/product_reports'), $fileName);
                $product->test_report_en71 = $fileName;
            }

            // Main Product Image
            if ($request->hasFile('product_image')) {
                $file = $request->file('product_image');
                $file_name = uniqid('product_', true) . '.' . $file->getClientOriginalExtension();
                $img = $manager->read($file->getRealPath());
                $img->resize(583, 583);
                $img->save(public_path('upload/product_image/') . $file_name);
                $product->product_image = $file_name;
            }

            $product->save();

            // Multiple Gallery Images
            if ($request->hasFile('product_gallery_images')) {
                foreach ($request->file('product_gallery_images') as $file) {
                    $file_name = uniqid('gallery_', true) . '.' . $file->getClientOriginalExtension();
                    $img = $manager->read($file->getRealPath());
                    $img->resize(583, 583);
                    $img->save(public_path('upload/product_gallery/') . $file_name);

                    ProductGallery::create([
                        'product_id' => $product->id,
                        'product_gallery_image' => $file_name,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('backend.products.list')
                ->with(['message' => 'Product created successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Product Create Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with(['message' => 'Failed to create product.', 'alert-type' => 'error']);
        }
    }

    // ========== Edit Form ==========
    public function ProductEdit($id)
    {
        $product_info = Product::findOrFail($id);

        $categories = ProductCategory::where('product_category_status', 'active')->get();
        $subcategories = ProductSubCategory::where('product_sub_category_status', 'active')->get();
        $ageGroups = AgeGroup::orderBy('id', 'asc')->get();

        return view('backend.products.edit', compact('product_info', 'categories', 'subcategories', 'ageGroups'));
    }

    // ========== Update ==========
    public function ProductUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'product_name' => 'required|string|max:255',
                'product_slug' => 'required|string|max:255|unique:products,product_slug,' . $request->id,
                'product_category_id' => 'required|exists:product_categories,id',
                'product_sub_category_id' => 'nullable|exists:product_sub_categories,id',
                'product_price' => 'required|numeric|min:0',
                'discount_price' => 'nullable|numeric|min:0',
                'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'age_group_id' => 'required|exists:age_groups,id',
                'test_report_astm' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
                'test_report_en71' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
                'stock_status' => 'required|in:in_stock,out_of_stock',
            ],
            [
                'product_name.required' => 'Product name is required',
                'product_slug.required' => 'Slug is required',
                'product_slug.unique' => 'Slug already exists',
                'product_category_id.required' => 'Category is required',
                'product_image.image' => 'Product image must be an image file',
                'age_group_id.required' => 'Age group is required',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($request->id);
            $product->product_name = $request->product_name;
            $product->product_slug = Str::slug($request->product_slug, '-');
            $product->product_category_id = $request->product_category_id;
            $product->product_sub_category_id = $request->product_sub_category_id;
            $product->age_group_id = $request->age_group_id;
            $product->product_price = $request->product_price;
            $product->discount_price = $request->discount_price;
            $product->product_short_description = $request->product_short_description;
            $product->product_description = $request->product_description;
            $product->product_specifications = $request->product_specifications;
            $product->is_wholesale = $request->has('is_wholesale');
            $product->is_free_delivery = $request->has('is_free_delivery');
            $product->stock_status = $request->stock_status ?? 'in_stock';
            $product->product_status = $request->product_status ?? 'active';

            // Update ASTM Report
            if ($request->hasFile('test_report_astm')) {
                if ($product->test_report_astm) {
                    $old = public_path('upload/product_reports/' . $product->test_report_astm);
                    if (file_exists($old)) {
                        @unlink($old);
                    }
                }

                $file = $request->file('test_report_astm');
                $fileName = uniqid('astm_', true) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/product_reports'), $fileName);
                $product->test_report_astm = $fileName;
            }

            // Update EN71 Report
            if ($request->hasFile('test_report_en71')) {
                if ($product->test_report_en71) {
                    $old = public_path('upload/product_reports/' . $product->test_report_en71);
                    if (file_exists($old)) {
                        @unlink($old);
                    }
                }

                $file = $request->file('test_report_en71');
                $fileName = uniqid('en71_', true) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/product_reports'), $fileName);
                $product->test_report_en71 = $fileName;
            }

            if ($request->hasFile('product_image')) {
                $oldImage = public_path('upload/product_image/' . $product->product_image);
                if ($product->product_image && file_exists($oldImage)) {
                    @unlink($oldImage);
                }

                $file = $request->file('product_image');
                $manager = new ImageManager(new Driver());
                $file_name = uniqid('product_', true) . '.' . $file->getClientOriginalExtension();
                $img = $manager->read($file->getRealPath());
                $img->resize(440, 440);
                $img->save(public_path('upload/product_image/') . $file_name);
                $product->product_image = $file_name;
            }

            $product->save();

            DB::commit();

            return redirect()
                ->back()
                ->with([
                    'message' => 'Product updated successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Product Update Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Failed to update product.',
                    'alert-type' => 'error',
                ]);
        }
    }

    // ========== Delete ==========
    public function ProductDelete($id)
    {
        try {
            DB::beginTransaction();

            $product = Product::with('galleries')->findOrFail($id);

            if ($product->test_report_astm) {
                $file = public_path('upload/product_reports/' . $product->test_report_astm);
                if (file_exists($file)) {
                    @unlink($file);
                }
            }

            if ($product->test_report_en71) {
                $file = public_path('upload/product_reports/' . $product->test_report_en71);
                if (file_exists($file)) {
                    @unlink($file);
                }
            }

            // Delete main product image
            if ($product->product_image) {
                $oldImage = public_path('upload/product_image/' . $product->product_image);
                if (file_exists($oldImage)) {
                    @unlink($oldImage);
                }
            }

            // Delete gallery images
            foreach ($product->galleries as $gallery) {
                $galleryImage = public_path('upload/product_gallery/' . $gallery->product_gallery_image);
                if (file_exists($galleryImage)) {
                    @unlink($galleryImage);
                }
            }

            // Delete product (related gallery rows will be deleted automatically via foreign key cascade)
            $product->delete();

            DB::commit();

            return redirect()
                ->route('backend.products.list')
                ->with([
                    'message' => 'Product and related gallery images deleted successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Product Delete Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with([
                    'message' => 'Failed to delete product.',
                    'alert-type' => 'error',
                ]);
        }
    }

    // Update individual gallery image
    public function ProductGalleryUpdate(Request $request, $id)
    {
        $gallery = ProductGallery::findOrFail($id);

        $request->validate([
            'gallery_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        try {
            $manager = new ImageManager(new Driver());

            // Delete old image
            $oldImage = public_path('upload/product_gallery/' . $gallery->product_gallery_image);
            if (file_exists($oldImage)) {
                @unlink($oldImage);
            }

            // Save new image
            $file = $request->file('gallery_image');
            $file_name = uniqid('gallery_', true) . '.' . $file->getClientOriginalExtension();
            $img = $manager->read($file->getRealPath());
            $img->resize(583, 583);
            $img->save(public_path('upload/product_gallery/') . $file_name);

            $gallery->product_gallery_image = $file_name;
            $gallery->save();

            return redirect()
                ->back()
                ->with(['message' => 'Gallery image updated!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            Log::error('Gallery Update Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with(['message' => 'Failed to update gallery image.', 'alert-type' => 'error']);
        }
    }

    // Delete individual gallery image
    public function ProductGalleryDelete($id)
    {
        $gallery = ProductGallery::findOrFail($id);

        try {
            $galleryImage = public_path('upload/product_gallery/' . $gallery->product_gallery_image);
            if (file_exists($galleryImage)) {
                @unlink($galleryImage);
            }

            $gallery->delete();

            return redirect()
                ->back()
                ->with(['message' => 'Gallery image deleted!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            Log::error('Gallery Delete Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with(['message' => 'Failed to delete gallery image.', 'alert-type' => 'error']);
        }
    }

    public function ProductGalleryAdd(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
            'product_gallery_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        try {
            $manager = new ImageManager(new Driver());
            $product = Product::findOrFail($request->id);

            if ($request->hasFile('product_gallery_images')) {
                foreach ($request->file('product_gallery_images') as $file) {
                    $file_name = uniqid('gallery_', true) . '.' . $file->getClientOriginalExtension();
                    $img = $manager->read($file->getRealPath());
                    $img->resize(583, 583);
                    $img->save(public_path('upload/product_gallery/') . $file_name);

                    ProductGallery::create([
                        'product_id' => $product->id,
                        'product_gallery_image' => $file_name,
                    ]);
                }
            }

            return redirect()
                ->back()
                ->with([
                    'message' => 'New gallery images added successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            Log::error('Add Gallery Images Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with([
                    'message' => 'Failed to add gallery images.',
                    'alert-type' => 'error',
                ]);
        }
    }
}
