<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductGallery;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    /* ===================== Product List ===================== */
    public function ProductList()
    {
        $product_list = Product::with(['category', 'brand'])
            ->latest()
            ->get();

        return view('backend.products.list', compact('product_list'));
    }

    /* ===================== Add Form ===================== */
    public function ProductAdd()
    {
        $categories = ProductCategory::where('product_category_status', 'active')->get();
        $brands = ProductBrand::where('product_brand_status', 'active')->orderBy('product_brand_name')->get();

        return view('backend.products.add', compact('categories', 'brands'));
    }

    /* ===================== Store ===================== */
    public function ProductStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'product_slug' => 'required|string|max:255|unique:products,product_slug',
            'product_category_id' => 'required|exists:product_categories,id',
            'brand_id' => 'required|exists:product_brands,id',

            'product_price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',

            'product_part_number' => 'required|string|max:255',
            'package' => 'required|string|max:255',
            'date_code' => 'required|string|max:255',

            'product_description' => 'nullable|string',

            'product_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'product_gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'stock_status' => 'required|in:in_stock,out_of_stock',
            'status' => 'required|in:active,inactive',

            'is_flash_sale' => 'nullable|boolean',
            'is_it_product' => 'nullable|boolean',

            'spec_key.*' => 'nullable|string|max:191',
            'spec_value.*' => 'nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->discount_price && $request->discount_price > $request->product_price) {
            return back()
                ->withErrors(['discount_price' => 'Discount price cannot be greater than product price'])
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $manager = new ImageManager(new Driver());

            $product = Product::create([
                'product_name' => $request->product_name,
                'product_slug' => Str::slug($request->product_slug),
                'product_category_id' => $request->product_category_id,
                'brand_id' => $request->brand_id,
                'product_price' => $request->product_price,
                'discount_price' => $request->discount_price,
                'product_part_number' => $request->product_part_number,
                'package' => $request->package,
                'date_code' => $request->date_code,
                'product_description' => $request->product_description,
                'stock_status' => $request->stock_status,
                'status' => $request->status,
                'is_flash_sale' => $request->boolean('is_flash_sale'),
                'is_it_product' => $request->boolean('is_it_product'),
            ]);

            /* ---- Main Image ---- */
            if ($request->hasFile('product_image')) {
                $file = $request->file('product_image');
                $name = uniqid('product_', true) . '.' . $file->getClientOriginalExtension();
                $path = public_path('upload/product_image/');

                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }

                $manager
                    ->read($file)
                    ->resize(583, 583)
                    ->save($path . $name);
                $product->update(['product_image' => 'upload/product_image/' . $name]);
            }

            /* ---- Gallery ---- */
            if ($request->hasFile('product_gallery_images')) {
                foreach ($request->file('product_gallery_images') as $file) {
                    $name = uniqid('gallery_', true) . '.' . $file->getClientOriginalExtension();
                    $manager
                        ->read($file)
                        ->resize(583, 583)
                        ->save(public_path('upload/product_gallery/' . $name));

                    ProductGallery::create([
                        'product_id' => $product->id,
                        'product_gallery_image' => $name,
                    ]);
                }
            }

            /* ---- Specifications ---- */
            foreach ($request->spec_key ?? [] as $i => $key) {
                if ($key && ($request->spec_value[$i] ?? null)) {
                    ProductSpecification::create([
                        'product_id' => $product->id,
                        'spec_key' => $key,
                        'spec_value' => $request->spec_value[$i],
                        'sort_order' => $i,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('backend.products.list')
                ->with(['message' => 'Product created successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return back()->with(['message' => 'Product create failed', 'alert-type' => 'error']);
        }
    }

    /* ===================== Edit ===================== */
    public function ProductEdit($id)
    {
        $product_info = Product::with(['galleries', 'specifications'])->findOrFail($id);
        $categories = ProductCategory::where('product_category_status', 'active')->get();
        $brands = ProductBrand::where('product_brand_status', 'active')->get();

        return view('backend.products.edit', compact('product_info', 'categories', 'brands'));
    }

    /* ===================== Update ===================== */
    public function ProductUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'product_name' => 'required|string|max:255',
            'product_slug' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'brand_id' => 'required|exists:product_brands,id',

            'product_price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',

            'product_part_number' => 'required|string|max:255',
            'package' => 'required|string|max:255',
            'date_code' => 'required|string|max:255',

            'product_description' => 'nullable|string',

            'product_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'product_gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'stock_status' => 'required|in:in_stock,out_of_stock',
            'status' => 'required|in:active,inactive',

            'is_flash_sale' => 'nullable|boolean',
            'is_it_product' => 'nullable|boolean',

            'spec_key.*' => 'nullable|string|max:191',
            'spec_value.*' => 'nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $product = Product::findOrFail($request->product_id);

        // Unique slug check with current product
        $slugExists = Product::where('product_slug', Str::slug($request->product_slug))
            ->where('id', '!=', $product->id)
            ->exists();

        if ($slugExists) {
            return back()
                ->withErrors(['product_slug' => 'This slug is already taken'])
                ->withInput();
        }

        if ($request->discount_price && $request->discount_price > $request->product_price) {
            return back()
                ->withErrors(['discount_price' => 'Discount price cannot be greater than product price'])
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $manager = new ImageManager(new Driver());

            $product->update([
                'product_name' => $request->product_name,
                'product_slug' => Str::slug($request->product_slug),
                'product_category_id' => $request->product_category_id,
                'brand_id' => $request->brand_id,
                'product_price' => $request->product_price,
                'discount_price' => $request->discount_price,
                'product_part_number' => $request->product_part_number,
                'package' => $request->package,
                'date_code' => $request->date_code,
                'product_description' => $request->product_description,
                'stock_status' => $request->stock_status,
                'status' => $request->status,
                'is_flash_sale' => $request->boolean('is_flash_sale'),
                'is_it_product' => $request->boolean('is_it_product'),
            ]);

            /* ---- Main Image ---- */
            if ($request->hasFile('product_image')) {
                // Delete old image
                if ($product->product_image) {
                    @unlink(public_path($product->product_image));
                }

                $file = $request->file('product_image');
                $name = uniqid('product_', true) . '.' . $file->getClientOriginalExtension();
                $path = public_path('upload/product_image/');

                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }

                $manager
                    ->read($file)
                    ->resize(583, 583)
                    ->save($path . $name);
                $product->update(['product_image' => 'upload/product_image/' . $name]);
            }

            /* ---- Gallery ---- */
            if ($request->hasFile('product_gallery_images')) {
                foreach ($request->file('product_gallery_images') as $file) {
                    $name = uniqid('gallery_', true) . '.' . $file->getClientOriginalExtension();
                    $galleryPath = public_path('upload/product_gallery/');

                    if (!file_exists($galleryPath)) {
                        mkdir($galleryPath, 0755, true);
                    }

                    $manager
                        ->read($file)
                        ->resize(583, 583)
                        ->save($galleryPath . $name);

                    ProductGallery::create([
                        'product_id' => $product->id,
                        'product_gallery_image' => $name,
                    ]);
                }
            }

            /* ---- Specifications ---- */
            ProductSpecification::where('product_id', $product->id)->delete();

            foreach ($request->spec_key ?? [] as $i => $key) {
                if ($key && ($request->spec_value[$i] ?? null)) {
                    ProductSpecification::create([
                        'product_id' => $product->id,
                        'spec_key' => $key,
                        'spec_value' => $request->spec_value[$i],
                        'sort_order' => $i,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('backend.products.list')
                ->with(['message' => 'Product updated successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Product Update Error: ' . $e->getMessage());

            return back()
                ->with(['message' => 'Product update failed', 'alert-type' => 'error'])
                ->withInput();
        }
    }

    /* ===================== Delete ===================== */
    public function ProductDelete($id)
    {
        $product = Product::with('galleries')->findOrFail($id);

        foreach ($product->galleries as $gallery) {
            @unlink(public_path('upload/product_gallery/' . $gallery->product_gallery_image));
        }

        if ($product->product_image) {
            @unlink(public_path($product->product_image));
        }

        $product->delete();

        return back()->with(['message' => 'Product deleted successfully!', 'alert-type' => 'success']);
    }
}
