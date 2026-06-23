<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BatteryCategory;
use App\Models\ItProductCategory;
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
        $product_list = Product::with(['category', 'brand', 'itCategory', 'batteryCategory'])
            ->latest()
            ->get();

        return view('backend.products.list', compact('product_list'));
    }

    /* ===================== Add Form ===================== */
    public function ProductAdd()
    {
        $categories         = ProductCategory::where('product_category_status', 'active')->get();
        $brands             = ProductBrand::where('product_brand_status', 'active')->orderBy('id')->get();
        $it_categories      = ItProductCategory::where('status', 'active')->orderBy('name')->get();
        $battery_categories = BatteryCategory::where('status', 'active')->orderBy('name')->get();

        return view('backend.products.add', compact('categories', 'brands', 'it_categories', 'battery_categories'));
    }

    /* ===================== Store ===================== */
    public function ProductStore(Request $request)
    {
        $isItProduct = $request->boolean('is_it_product');
        $isBattery   = $request->boolean('is_battery');

        $rules = [
            'product_name'             => 'required|string|max:255',
            'product_slug'             => 'required|string|max:255|unique:products,product_slug',
            'product_price'            => 'nullable|numeric|min:0',
            'discount_price'           => 'nullable|numeric|min:0',
            'product_part_number'      => 'nullable|string|max:255',
            'package'                  => 'nullable|string|max:255',
            'date_code'                => 'nullable|string|max:255',
            'product_description'      => 'nullable|string',
            'product_image'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'product_gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'stock_status'             => 'required|in:in_stock,out_of_stock',
            'status'                   => 'required|in:active,inactive',
            'is_flash_sale'            => 'nullable|boolean',
            'is_it_product'            => 'nullable|boolean',
            'is_battery'               => 'nullable|boolean',
            'flash_sale_pdf'           => 'nullable|mimes:pdf|max:5120',
            'flash_sale_excel'         => 'nullable|mimes:xlsx,xls,csv|max:10240',
            'spec_key.*'               => 'nullable|string|max:191',
            'spec_value.*'             => 'nullable|string|max:2000',
        ];

        if ($isItProduct) {
            $rules['it_category_id']      = 'required|exists:it_product_categories,id';
            $rules['product_category_id'] = 'nullable';
            $rules['brand_id']            = 'nullable|exists:product_brands,id';
            $rules['battery_category_id'] = 'nullable';
        } elseif ($isBattery) {
            $rules['battery_category_id'] = 'required|exists:battery_categories,id';
            $rules['product_category_id'] = 'nullable';
            $rules['brand_id']            = 'nullable|exists:product_brands,id';
            $rules['it_category_id']      = 'nullable';
        } else {
            $rules['product_category_id'] = 'nullable|exists:product_categories,id';
            $rules['brand_id']            = 'nullable|exists:product_brands,id';
            $rules['it_category_id']      = 'nullable';
            $rules['battery_category_id'] = 'nullable';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $manager = new ImageManager(new Driver());

            $product = Product::create([
                'product_name'        => $request->product_name,
                'product_slug'        => Str::slug($request->product_slug),
                'product_category_id' => ($isItProduct || $isBattery) ? null : $request->product_category_id,
                'brand_id'            => $request->brand_id,
                'product_price'       => $request->product_price,
                'discount_price'      => $request->discount_price,
                'product_part_number' => $request->product_part_number,
                'package'             => $request->package,
                'date_code'           => $request->date_code,
                'product_description' => $request->product_description,
                'stock_status'        => $request->stock_status,
                'status'              => $request->status,
                'is_flash_sale'       => $request->boolean('is_flash_sale'),
                'is_it_product'       => $isItProduct,
                'it_category_id'      => $isItProduct ? $request->it_category_id : null,
                'is_battery'          => $isBattery,
                'battery_category_id' => $isBattery ? $request->battery_category_id : null,
            ]);

            /* ---- Main Image ---- */
            if ($request->hasFile('product_image')) {
                $file = $request->file('product_image');
                $name = uniqid('product_', true) . '.' . $file->getClientOriginalExtension();
                $path = public_path('upload/product_image/');
                if (!file_exists($path)) mkdir($path, 0755, true);
                $manager->read($file)->resize(583, 583)->save($path . $name);
                $product->update(['product_image' => 'upload/product_image/' . $name]);
            }

            /* ---- Gallery ---- */
            if ($request->hasFile('product_gallery_images')) {
                foreach ($request->file('product_gallery_images') as $file) {
                    $name        = uniqid('gallery_', true) . '.' . $file->getClientOriginalExtension();
                    $galleryPath = public_path('upload/product_gallery/');
                    if (!file_exists($galleryPath)) mkdir($galleryPath, 0755, true);
                    $manager->read($file)->resize(583, 583)->save($galleryPath . $name);
                    ProductGallery::create(['product_id' => $product->id, 'product_gallery_image' => $name]);
                }
            }

            /* ---- Flash Sale PDF ---- */
            if ($request->hasFile('flash_sale_pdf')) {
                $pdfDir  = public_path('upload/flash_sale_pdf');
                if (!file_exists($pdfDir)) mkdir($pdfDir, 0755, true);
                $pdf     = $request->file('flash_sale_pdf');
                $pdfName = uniqid('flash_pdf_', true) . '.' . $pdf->getClientOriginalExtension();
                $pdf->move($pdfDir, $pdfName);
                $product->update(['flash_sale_pdf' => 'upload/flash_sale_pdf/' . $pdfName]);
            }

            /* ---- Flash Sale Excel ---- */
            if ($request->hasFile('flash_sale_excel')) {
                $excelDir  = public_path('upload/flash_sale_excel');
                if (!file_exists($excelDir)) mkdir($excelDir, 0755, true);
                $excel     = $request->file('flash_sale_excel');
                $excelName = uniqid('flash_excel_', true) . '.' . $excel->getClientOriginalExtension();
                $excel->move($excelDir, $excelName);
                $product->update(['flash_sale_excel' => 'upload/flash_sale_excel/' . $excelName]);
            }

            /* ---- Specifications ---- */
            foreach ($request->spec_key ?? [] as $i => $key) {
                if ($key && ($request->spec_value[$i] ?? null)) {
                    ProductSpecification::create([
                        'product_id' => $product->id,
                        'spec_key'   => $key,
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
            Log::error('ProductStore Error: ' . $e->getMessage() . ' | Line: ' . $e->getLine());
            return back()->withInput()->with(['message' => 'Product create failed.', 'alert-type' => 'error']);
        }
    }

    /* ===================== Edit ===================== */
    public function ProductEdit($id)
    {
        $product_info       = Product::with(['galleries', 'specifications'])->findOrFail($id);
        $categories         = ProductCategory::where('product_category_status', 'active')->get();
        $brands             = ProductBrand::where('product_brand_status', 'active')->orderBy('id')->get();
        $it_categories      = ItProductCategory::where('status', 'active')->orderBy('name')->get();
        $battery_categories = BatteryCategory::where('status', 'active')->orderBy('name')->get();

        return view('backend.products.edit', compact('product_info', 'categories', 'brands', 'it_categories', 'battery_categories'));
    }

    /* ===================== Update ===================== */
    public function ProductUpdate(Request $request)
    {
        $isItProduct = $request->boolean('is_it_product');
        $isBattery   = $request->boolean('is_battery');

        $rules = [
            'product_id'               => 'required|exists:products,id',
            'product_name'             => 'required|string|max:255',
            'product_slug'             => 'required|string|max:255',
            'product_price'            => 'nullable|numeric|min:0',
            'discount_price'           => 'nullable|numeric|min:0',
            'product_part_number'      => 'nullable|string|max:255',
            'package'                  => 'nullable|string|max:255',
            'date_code'                => 'nullable|string|max:255',
            'product_description'      => 'nullable|string',
            'product_image'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'product_gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'stock_status'             => 'required|in:in_stock,out_of_stock',
            'status'                   => 'required|in:active,inactive',
            'is_flash_sale'            => 'nullable|boolean',
            'is_it_product'            => 'nullable|boolean',
            'is_battery'               => 'nullable|boolean',
            'flash_sale_pdf'           => 'nullable|mimes:pdf|max:5120',
            'flash_sale_excel'         => 'nullable|mimes:xlsx,xls,csv|max:10240',
            'spec_key.*'               => 'nullable|string|max:191',
            'spec_value.*'             => 'nullable|string|max:2000',
        ];

        if ($isItProduct) {
            $rules['it_category_id']      = 'required|exists:it_product_categories,id';
            $rules['product_category_id'] = 'nullable';
            $rules['brand_id']            = 'nullable|exists:product_brands,id';
            $rules['battery_category_id'] = 'nullable';
        } elseif ($isBattery) {
            $rules['battery_category_id'] = 'required|exists:battery_categories,id';
            $rules['product_category_id'] = 'nullable';
            $rules['brand_id']            = 'nullable|exists:product_brands,id';
            $rules['it_category_id']      = 'nullable';
        } else {
            $rules['product_category_id'] = 'nullable|exists:product_categories,id';
            $rules['brand_id']            = 'nullable|exists:product_brands,id';
            $rules['it_category_id']      = 'nullable';
            $rules['battery_category_id'] = 'nullable';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $product = Product::findOrFail($request->product_id);

        $slugExists = Product::where('product_slug', Str::slug($request->product_slug))
            ->where('id', '!=', $product->id)->exists();
        if ($slugExists) {
            return back()->withErrors(['product_slug' => 'This slug is already taken'])->withInput();
        }

        try {
            DB::beginTransaction();

            $manager = new ImageManager(new Driver());

            $product->update([
                'product_name'        => $request->product_name,
                'product_slug'        => Str::slug($request->product_slug),
                'product_category_id' => ($isItProduct || $isBattery) ? null : $request->product_category_id,
                'brand_id'            => $request->brand_id,
                'product_price'       => $request->product_price,
                'discount_price'      => $request->discount_price,
                'product_part_number' => $request->product_part_number,
                'package'             => $request->package,
                'date_code'           => $request->date_code,
                'product_description' => $request->product_description,
                'stock_status'        => $request->stock_status,
                'status'              => $request->status,
                'is_flash_sale'       => $request->boolean('is_flash_sale'),
                'is_it_product'       => $isItProduct,
                'it_category_id'      => $isItProduct ? $request->it_category_id : null,
                'is_battery'          => $isBattery,
                'battery_category_id' => $isBattery ? $request->battery_category_id : null,
            ]);

            /* ---- Main Image ---- */
            if ($request->hasFile('product_image')) {
                if ($product->product_image) @unlink(public_path($product->product_image));
                $file = $request->file('product_image');
                $name = uniqid('product_', true) . '.' . $file->getClientOriginalExtension();
                $path = public_path('upload/product_image/');
                if (!file_exists($path)) mkdir($path, 0755, true);
                $manager->read($file)->resize(583, 583)->save($path . $name);
                $product->update(['product_image' => 'upload/product_image/' . $name]);
            }

            /* ---- Gallery ---- */
            if ($request->hasFile('product_gallery_images')) {
                foreach ($request->file('product_gallery_images') as $file) {
                    $name        = uniqid('gallery_', true) . '.' . $file->getClientOriginalExtension();
                    $galleryPath = public_path('upload/product_gallery/');
                    if (!file_exists($galleryPath)) mkdir($galleryPath, 0755, true);
                    $manager->read($file)->resize(583, 583)->save($galleryPath . $name);
                    ProductGallery::create(['product_id' => $product->id, 'product_gallery_image' => $name]);
                }
            }

            /* ---- Flash Sale PDF ---- */
            if ($request->hasFile('flash_sale_pdf')) {
                if (!empty($product->flash_sale_pdf)) @unlink(public_path($product->flash_sale_pdf));
                $pdfDir  = public_path('upload/flash_sale_pdf');
                if (!file_exists($pdfDir)) mkdir($pdfDir, 0755, true);
                $pdf     = $request->file('flash_sale_pdf');
                $pdfName = uniqid('flash_pdf_', true) . '.' . $pdf->getClientOriginalExtension();
                $pdf->move($pdfDir, $pdfName);
                $product->update(['flash_sale_pdf' => 'upload/flash_sale_pdf/' . $pdfName]);
            }

            /* ---- Flash Sale Excel ---- */
            if ($request->hasFile('flash_sale_excel')) {
                if (!empty($product->flash_sale_excel)) @unlink(public_path($product->flash_sale_excel));
                $excelDir  = public_path('upload/flash_sale_excel');
                if (!file_exists($excelDir)) mkdir($excelDir, 0755, true);
                $excel     = $request->file('flash_sale_excel');
                $excelName = uniqid('flash_excel_', true) . '.' . $excel->getClientOriginalExtension();
                $excel->move($excelDir, $excelName);
                $product->update(['flash_sale_excel' => 'upload/flash_sale_excel/' . $excelName]);
            }

            /* ---- Specifications ---- */
            ProductSpecification::where('product_id', $product->id)->delete();
            foreach ($request->spec_key ?? [] as $i => $key) {
                if ($key && ($request->spec_value[$i] ?? null)) {
                    ProductSpecification::create([
                        'product_id' => $product->id,
                        'spec_key'   => $key,
                        'spec_value' => $request->spec_value[$i],
                        'sort_order' => $i,
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()
                ->with(['message' => 'Product updated successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('ProductUpdate Error: ' . $e->getMessage() . ' | Line: ' . $e->getLine());
            return back()->withInput()->with(['message' => 'Product update failed.', 'alert-type' => 'error']);
        }
    }

    /* ===================== Delete ===================== */
    public function ProductDelete($id)
    {
        $product = Product::with('galleries')->findOrFail($id);

        foreach ($product->galleries as $gallery) {
            @unlink(public_path('upload/product_gallery/' . $gallery->product_gallery_image));
        }
        if ($product->product_image)    @unlink(public_path($product->product_image));
        if ($product->flash_sale_pdf)   @unlink(public_path($product->flash_sale_pdf));
        if ($product->flash_sale_excel) @unlink(public_path($product->flash_sale_excel));

        $product->delete();

        return back()->with(['message' => 'Product deleted successfully!', 'alert-type' => 'success']);
    }

    /* ===================== AJAX ===================== */
    public function ajaxSearch(Request $request)
    {
        $query    = $request->input('query');
        $products = Product::where('product_name', 'LIKE', "%{$query}%")->paginate(20);
        $html     = view('frontend.partials.product_grid', compact('products'))->render();
        return response()->json(['html' => $html, 'total' => $products->total()]);
    }

    public function ajaxProducts(Request $request)
    {
        $query      = $request->input('query');
        $categories = $request->input('categories', []);
        $brands     = $request->input('brands', []);

        $products = Product::query()
            ->where('is_battery', false)
            ->where('is_it_product', false)
            ->where('is_flash_sale', false)
            ->where('status', 'active');

        if ($query)              $products->where('product_name', 'LIKE', "%{$query}%");
        if (!empty($categories)) $products->whereIn('product_category_id', $categories);
        if (!empty($brands))     $products->whereIn('brand_id', $brands);

        $products    = $products->with(['category', 'brand'])->paginate(20);
        $html        = view('frontend.partials.product_list_wrapper', compact('products'))->render();
        $showingText = "Showing {$products->firstItem()}–{$products->lastItem()} of {$products->total()} results";

        return response()->json(['html' => $html, 'showing_text' => $showingText]);
    }

    public function ajaxFlashSale(Request $request)
    {
        $query    = $request->input('query');
        $products = Product::query()
            ->where('is_flash_sale', 1)
            ->where('status', 'active');

        if ($query) {
            $products->where(function ($q) use ($query) {
                $q->where('product_name', 'LIKE', "%{$query}%")
                    ->orWhere('product_part_number', 'LIKE', "%{$query}%");
            });
        }

        $products    = $products->with(['brand'])->paginate(15);
        $html        = view('frontend.partials.flash_sale_table_wrapper', compact('products'))->render();
        $showingText = $products->total() > 0
            ? "Showing {$products->firstItem()}–{$products->lastItem()} of {$products->total()} results"
            : 'Showing 0–0 of 0 results';

        return response()->json(['html' => $html, 'showing_text' => $showingText]);
    }

    /* ===================== Gallery ===================== */
    public function ProductGalleryDelete($id)
    {
        $gallery = ProductGallery::findOrFail($id);
        @unlink(public_path('upload/product_gallery/' . $gallery->product_gallery_image));
        $gallery->delete();
        return back()->with(['message' => 'Gallery image deleted!', 'alert-type' => 'success']);
    }
}
