<?php

namespace App\Http\Controllers;

use App\Models\AboutCompany;
use App\Models\AgeGroup;
use App\Models\Blog;
use App\Models\BlogCategories;
use App\Models\BulkOrder;
use App\Models\Careers;
use App\Models\Clients;
use App\Models\HeroSection;
use App\Models\MissionVision;
use App\Models\CareerForm;
use App\Models\Certificate;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductReview;
use App\Models\ProductSubCategory;
use App\Models\Services;
use App\Models\Slider;
use App\Models\Team;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FrontendController extends Controller
{
    public function Index()
    {
        $slider_data = Slider::where('slider_status', 'active')->latest()->get();

        $product_data = Product::where('status', 'active')->latest()->take(10)->get();

        $product_brand_data = ProductBrand::where('product_brand_status', 'active')->orderBy('id', 'asc')->take(10)->get();

        // Get all active categories with their latest products
        $categories = ProductCategory::with([
            'products' => function ($query) {
                $query->where('status', 'active')->latest()->take(8); // adjust limit as needed
            },
        ])
            ->orderBy('product_category_name', 'asc')
            ->where('product_category_status', 'active')
            ->latest()
            ->get();

        $certificate_data = Certificate::where('certificate_status', 'active')->latest()->get();

        return view('frontend.index', compact('slider_data', 'product_brand_data', 'product_data', 'categories', 'certificate_data'));
    }

    public function Products(Request $request)
    {
        $query = Product::with(['category', 'brand'])->where('status', 'active');

        // Price
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereRaw('COALESCE(product_price - discount_price, product_price) BETWEEN ? AND ?', [$request->min_price, $request->max_price]);
        }

        // Categories (checkbox)
        if ($request->filled('categories')) {
            $query->whereIn('product_category_id', $request->categories);
        }

        // Brands (checkbox)
        if ($request->filled('brands')) {
            $query->whereIn('brand_id', $request->brands);
        }

        $product_data = $query->latest()->paginate(20)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('frontend.partials.product-list', compact('product_data'))->render(),
                'showing_text' => 'Showing ' . ($product_data->firstItem() ?? 0) . '–' . ($product_data->lastItem() ?? 0) . ' of ' . $product_data->total() . ' results',
            ]);
        }

        $category_data = ProductCategory::where('product_category_status', 'active')
            ->withCount(['products' => fn($q) => $q->where('status', 'active')])
            ->get();

        $product_brand_data = ProductBrand::where('product_brand_status', 'active')
            ->withCount(['products' => fn($q) => $q->where('status', 'active')])
            ->get();

        return view('frontend.pages.products', compact('product_data', 'category_data', 'product_brand_data'));
    }

    public function Cart()
    {
        return view('frontend.pages.cart');
    }

    public function Checkout()
    {
        return view('frontend.pages.checkout');
    }

    public function ProductDetails($slug)
    {
        $product = Product::with([
            'category',
            'brand',
            'galleries',
            'specifications',
            'reviews' => function ($query) {
                $query->where('status', 'accept')->latest();
            },
        ])
            ->where('product_slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $related_products = Product::with(['brand'])
            ->where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->where('stock_status', 'in_stock')
            ->latest()
            ->take(10)
            ->get();

        return view('frontend.details.product_details', compact('product', 'related_products'));
    }

    public function bulkOrderSubmit(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'message' => 'nullable|string',
        ]);

        BulkOrder::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'quantity' => $request->quantity,
            'message' => $request->message,
        ]);

        return back()->with('success', '✅ Thank you! Your order request has been submitted successfully.');
    }

    public function ProductByBrand(Request $request, $slug)
    {
        $brand_info = ProductBrand::where('product_brand_slug', $slug)->firstOrFail();

        $query = Product::with(['category', 'brand', 'galleries'])->where('status', 'active');

        // 🔥 Base brand (page slug)
        if ($request->filled('brands')) {
            // checkbox brand select থাকলে
            $query->whereIn('brand_id', $request->brands);
        } else {
            // না থাকলে slug brand
            $query->where('brand_id', $brand_info->id);
        }

        // 🔥 Category checkbox
        if ($request->filled('categories')) {
            $query->whereIn('product_category_id', $request->categories);
        }

        // 🔥 Price filter
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereRaw('COALESCE(product_price - discount_price, product_price) BETWEEN ? AND ?', [$request->min_price, $request->max_price]);
        }

        $product_data = $query->latest()->paginate(20)->withQueryString();

        // AJAX
        if ($request->ajax()) {
            return response()->json([
                'html' => view('frontend.partials.product-list', compact('product_data'))->render(),
                'showing_text' => 'Showing ' . ($product_data->firstItem() ?? 0) . '–' . ($product_data->lastItem() ?? 0) . ' of ' . $product_data->total() . ' results',
            ]);
        }

        $category_data = ProductCategory::where('product_category_status', 'active')
            ->withCount(['products' => fn($q) => $q->where('status', 'active')])
            ->get();

        $product_brand_data = ProductBrand::where('product_brand_status', 'active')
            ->withCount(['products' => fn($q) => $q->where('status', 'active')])
            ->get();

        return view('frontend.pages.product_by_brand', compact('brand_info', 'product_data', 'product_brand_data', 'category_data'));
    }

    public function ProductByCategory(Request $request, $slug)
    {
        $category = ProductCategory::where('product_category_slug', $slug)->firstOrFail();

        $query = Product::with(['category', 'brand', 'galleries'])->where('status', 'active');

        // 🔥 Base category (page slug)
        if ($request->filled('categories')) {
            // checkbox category select থাকলে
            $query->whereIn('product_category_id', $request->categories);
        } else {
            // না থাকলে slug category
            $query->where('product_category_id', $category->id);
        }

        // 🔥 Brand checkbox
        if ($request->filled('brands')) {
            $query->whereIn('brand_id', $request->brands);
        }

        // 🔥 Price filter
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereRaw('COALESCE(product_price - discount_price, product_price) BETWEEN ? AND ?', [$request->min_price, $request->max_price]);
        }

        $product_data = $query->latest()->paginate(20)->withQueryString();

        // AJAX
        if ($request->ajax()) {
            return response()->json([
                'html' => view('frontend.partials.product-list', compact('product_data'))->render(),
                'showing_text' => 'Showing ' . ($product_data->firstItem() ?? 0) . '–' . ($product_data->lastItem() ?? 0) . ' of ' . $product_data->total() . ' results',
            ]);
        }

        $category_data = ProductCategory::where('product_category_status', 'active')
            ->withCount(['products' => fn($q) => $q->where('status', 'active')])
            ->get();

        $product_brand_data = ProductBrand::where('product_brand_status', 'active')
            ->withCount(['products' => fn($q) => $q->where('status', 'active')])
            ->get();

        return view('frontend.pages.product_by_category', compact('category', 'product_data', 'product_brand_data', 'category_data'));
    }

    public function ProductBySubCategory($slug)
    {
        // Get subcategory along with parent category and active products
        $subcategory = ProductSubCategory::with([
            'category',
            'products' => function ($query) {
                $query->where('status', 'active')->orderBy('created_at', 'desc');
            },
        ])
            ->where('product_sub_category_slug', $slug)
            ->firstOrFail();

        $category = $subcategory->category;

        return view('frontend.pages.product_by_subcategory', compact('subcategory', 'category'));
    }

    public function ProductByAge($slug)
    {
        $age_group = AgeGroup::where('slug', $slug)
            ->with([
                'products' => function ($query) {
                    $query->where('status', 'active')->orderBy('created_at', 'desc');
                },
            ])
            ->firstOrFail();

        return view('frontend.pages.product_by_age', compact('age_group'));
    }

    public function Contact()
    {
        return view('frontend.pages.contact');
    } // End Method

    public function Blog()
    {
        $blog_list = Blog::where('blog_status', 'active')->latest()->paginate(12);
        return view('frontend.pages.blog', compact('blog_list'));
    } // End Method

    public function BlogDetails($slug)
    {
        $blog_details = Blog::where('blog_slug', $slug)->where('blog_status', 'active')->firstOrFail();

        $blog_category = BlogCategories::latest()->get();

        $blog_list = Blog::where('blog_status', 'active')->latest()->take(5)->get();

        return view('frontend.details.blog_details', compact('blog_details', 'blog_category', 'blog_list'));
    } // End Method

    public function PrivacyPolicy()
    {
        return view('frontend.pages.privacy_policy');
    } // End Method

    public function TermsConditions()
    {
        return view('frontend.pages.terms_conditions');
    } // End Method

    public function AboutUs()
    {
        $about_company = AboutCompany::latest()->first();
        $mission_vision = MissionVision::latest()->get();
        return view('frontend.pages.about_us', compact('about_company', 'mission_vision'));
    } //End Method

    public function ChildDevelopment()
    {
        return view('frontend.pages.child_development');
    }

    public function FlashSale()
    {
        $product_data = Product::where('is_flash_sale', true)->where('status', 'active')->with('category', 'brand', 'galleries')->orderBy('created_at', 'desc')->paginate(12);

        $product_brand_data = ProductBrand::where('product_brand_status', 'active')
            ->orderBy('product_brand_name')
            ->withCount([
                'products' => function ($query) {
                    $query->where('is_flash_sale', true)->where('status', 'active');
                },
            ])
            ->get();

        $category_data = ProductCategory::where('product_category_status', 'active')->orderBy('product_category_name')->get();

        return view('frontend.pages.flash_sale', compact('product_data', 'product_brand_data', 'category_data'));
    }

    public function ItProduct(Request $request)
    {
        $query = Product::where('is_it_product', true)->where('status', 'active')->with('category', 'brand', 'galleries', 'itCategory');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                    ->orWhere('product_part_number', 'like', "%{$search}%")
                    ->orWhere('package', 'like', "%{$search}%")
                    ->orWhere('date_code', 'like', "%{$search}%");
            });
        }

        // Brand filter
        if ($request->filled('brands')) {
            $query->whereIn('brand_id', $request->brands);
        }

        // IT Category filter
        if ($request->filled('it_categories')) {
            $query->whereIn('it_category_id', $request->it_categories);
        }

        $product_data = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('frontend.partials.product-list', compact('product_data'))->render(),
                'showing_text' => 'Showing ' . ($product_data->firstItem() ?? 0) . '–' . ($product_data->lastItem() ?? 0) . ' of ' . $product_data->total() . ' results',
            ]);
        }

        $product_brand_data = ProductBrand::where('product_brand_status', 'active')
            ->withCount(['products' => fn($q) => $q->where('is_it_product', true)->where('status', 'active')])
            ->having('products_count', '>', 0)
            ->orderBy('product_brand_name')
            ->get();

        $it_category_data = \App\Models\ItProductCategory::where('status', 'active')
            ->withCount(['products' => fn($q) => $q->where('status', 'active')])
            ->having('products_count', '>', 0)
            ->orderBy('name')
            ->get();

        return view('frontend.pages.it_product', compact('product_data', 'product_brand_data', 'it_category_data'));
    }

    public function ajaxSearch(Request $request)
    {
        $query = $request->get('query');
        $products = Product::where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('product_name', 'like', "%{$query}%")
                    ->orWhere('product_part_number', 'like', "%{$query}%")
                    ->orWhere('package', 'like', "%{$query}%")
                    ->orWhere('date_code', 'like', "%{$query}%");
            })
            ->limit(8)
            ->get();

        $html = '';
        if ($products->count()) {
            foreach ($products as $product) {
                $html .=
                    '<a href="' .
                    route('product.details', $product->product_slug) .
                    '"
                   style="display:flex;gap:12px;padding:10px;border-bottom:1px solid #eee;text-decoration:none;">
                    <img src="' .
                    asset($product->product_image) .
                    '"
                         style="width:50px;height:50px;border-radius:6px;object-fit:cover;">
                    <div>
                        <div style="font-weight:600;color:#222;">' .
                    e(Str::limit($product->product_name, 45)) .
                    '</div>
                        <div style="color:#888;font-size:12px;margin-top:3px;">' .
                    e($product->product_part_number) .
                    '</div>
                    </div>
                </a>';
            }
        } else {
            $html = '<p style="padding:12px;text-align:center;color:#888;">No products found</p>';
        }

        return response()->json(['html' => $html]);
    }

    public function Brands()
    {
        $product_brand_data = ProductBrand::where('product_brand_status', 'active')->orderBy('id', 'asc')->get();

        return view('frontend.pages.brands', compact('product_brand_data'));
    }
}
