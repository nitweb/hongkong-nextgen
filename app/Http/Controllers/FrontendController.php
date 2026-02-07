<?php

namespace App\Http\Controllers;

use App\Models\AboutCompany;
use App\Models\AgeGroup;
use App\Models\Blog;
use App\Models\BulkOrder;
use App\Models\Careers;
use App\Models\Clients;
use App\Models\HeroSection;
use App\Models\MissionVision;
use App\Models\CareerForm;
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

        $product_brand_data = ProductBrand::where('product_brand_status', 'active')->latest()->take(8)->get();

        // Get all active categories with their latest products
        $categories = ProductCategory::with([
            'products' => function ($query) {
                $query->where('product_status', 'active')->latest()->take(8); // adjust limit as needed
            },
        ])
            ->orderBy('product_category_name', 'asc')
            ->where('product_category_status', 'active')
            ->latest()
            ->get();

        return view('frontend.index', compact('slider_data', 'product_brand_data', 'categories'));
    }

    public function Shop()
    {
        // Fetch all active products with their category, subcategory, and galleries
        $products = Product::with(['category', 'subcategory', 'galleries'])
            ->where('product_status', 'active')
            ->latest()
            ->get();

        return view('frontend.pages.shop', compact('products'));
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
            'subcategory',
            'galleries',
            'reviews' => function ($query) {
                $query->where('status', 'accept')->latest(); // Only accepted reviews
            },
        ])
            ->where('product_slug', $slug)
            ->where('product_status', 'active')
            ->firstOrFail();

        $related_products = Product::where('product_category_id', $product->product_category_id)->where('id', '!=', $product->id)->where('product_status', 'active')->latest()->take(10)->get();

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

    public function ProductByCategory($slug)
    {
        $category = ProductCategory::where('product_category_slug', $slug)
            ->with([
                'products' => function ($query) {
                    $query->where('product_status', 'active')->orderBy('created_at', 'desc');
                },
            ])
            ->firstOrFail();

        return view('frontend.pages.product_by_category', compact('category'));
    }

    public function ProductBySubCategory($slug)
    {
        // Get subcategory along with parent category and active products
        $subcategory = ProductSubCategory::with([
            'category',
            'products' => function ($query) {
                $query->where('product_status', 'active')->orderBy('created_at', 'desc');
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
                    $query->where('product_status', 'active')->orderBy('created_at', 'desc');
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
        $blog_list = Blog::where('blog_status', 'active')->latest()->get();
        return view('frontend.pages.blog', compact('blog_list'));
    } // End Method

    public function BlogDetails($slug)
    {
        $blog_details = Blog::where('blog_slug', $slug)->where('blog_status', 'active')->firstOrFail();
        $blog_list = Blog::where('blog_status', 'active')->latest()->take(5)->get();
        $recent_products = Product::where('product_status', 'active')->take(5)->get();
        return view('frontend.details.blog_details', compact('blog_details', 'blog_list', 'recent_products'));
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

    public function ajaxSearch(Request $request)
    {
        $query = $request->get('query');

        $products = Product::where('product_name', 'like', "%{$query}%")
            ->orWhere('product_short_description', 'like', "%{$query}%")
            ->limit(8)
            ->get();

        $html = '';

        if ($products->count() > 0) {
            foreach ($products as $product) {
                $finalPrice = $product->product_price - ($product->discount_price ?? 0);
                $html .=
                    '
                <a href="' .
                    route('product.details', $product->product_slug) .
                    '"
                   style="display:flex; align-items:center; gap:10px; padding:8px 12px; border-bottom:1px solid #eee; text-decoration:none; color:#333;">
                    <img src="' .
                    asset('upload/product_image/' . $product->product_image) .
                    '"
                         alt="' .
                    $product->product_name .
                    '"
                         style="width:45px; height:45px; border-radius:5px; object-fit:cover;">
                    <div>
                        <strong>' .
                    e(Str::limit($product->product_name, 60)) .
                    '</strong><br>
                        <div style="font-size:13px;margin-top:10px;">
                    <span style="font-weight:600;color:#e74399;">
                        $' .
                    number_format($finalPrice, 2) .
                    '
                    </span>';

                if ($product->discount_price > 0) {
                    $html .=
                        '
                    <span style="margin-left:6px;color:#999;text-decoration:line-through;">
                        $' .
                        number_format($product->product_price, 2) .
                        '
                    </span>';
                }

                $html .= '
                </div>
                    </div>
                </a>';
            }
        } else {
            $html = '<p style="padding:10px; text-align:center; color:#888;">No products found.</p>';
        }

        return response()->json(['html' => $html]);
    }

    public function ChildDevelopment()
    {
        return view('frontend.pages.child_development');
    }

    public function WholesaleProducts()
    {
        $products = Product::with(['category', 'subcategory', 'galleries'])
            ->where('product_status', 'active')
            ->where('is_wholesale', true) // 🔴 exclude wholesale
            ->latest()
            ->get();

        return view('frontend.pages.wholesale', compact('products'));
    }
}
