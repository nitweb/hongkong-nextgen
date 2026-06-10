<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\AboutCompanyController;
use App\Http\Controllers\Backend\AgeGroupController;
use App\Http\Controllers\Backend\BatteryCategoryController;
use App\Http\Controllers\Backend\BatteryModuleController;
use App\Http\Controllers\Backend\BlogCategoriesController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\BulkOrderController;
use App\Http\Controllers\Backend\CertificateController;
use App\Http\Controllers\Backend\ContactFormController;
use App\Http\Controllers\Backend\ItProductCategoryController;
use App\Http\Controllers\Backend\MissionVisionController;
use App\Http\Controllers\Backend\ProductBrandController;
use App\Http\Controllers\Backend\ProductCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductReviewController;
use App\Http\Controllers\Backend\ProductSubCategoryController;
use App\Http\Controllers\Backend\SiteSettingsController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GlobalController;
use Illuminate\Support\Facades\Route;

// #################### Frontend Controller ####################
Route::middleware('web')->group(function () {
    // Home
    Route::get('/', [FrontendController::class, 'Index'])->name('index');

    // Shop
    Route::get('/products', [FrontendController::class, 'Products'])->name('products');

    // Cart
    Route::get('/cart', [FrontendController::class, 'Cart'])->name('cart');

    // Checkout
    Route::get('/checkout', [FrontendController::class, 'checkout'])->name('checkout');

    // Product Details
    Route::get('/product/{slug}', [FrontendController::class, 'ProductDetails'])->name('product.details');

    // Product Review
    Route::post('/product/review', [ProductReviewController::class, 'storeReview'])->name('product.review.store');

    // Bulk Order Submit
    Route::post('/bulk-order-submit', [FrontendController::class, 'bulkOrderSubmit'])->name('bulk.order.submit');

    // Product By Category
    Route::get('/brand/{slug}', [FrontendController::class, 'ProductByBrand'])->name('product.by.brand');

    // Product By Category
    Route::get('/category/{slug}', [FrontendController::class, 'ProductByCategory'])->name('product.by.category');

    // Product By Sub-Category
    Route::get('/sub-category/{slug}', [FrontendController::class, 'ProductBySubCategory'])->name('product.by.subcategory');

    // Product By Age
    Route::get('/age/{slug}', [FrontendController::class, 'ProductByAge'])->name('product.by.age');

    // Contact Us
    Route::get('/contact', [FrontendController::class, 'Contact'])->name('contact');
    Route::post('/contact/submit', [ContactFormController::class, 'ContactSubmit'])->name('contact.submit');

    // Blog
    Route::get('/blog', [FrontendController::class, 'Blog'])->name('blog');
    Route::get('/blog/{slug}', [FrontendController::class, 'BlogDetails'])->name('blog.details');

    // Privacy Policy
    Route::get('/privacy-policy', [FrontendController::class, 'PrivacyPolicy'])->name('privacy.policy');

    // Terms Conditions
    Route::get('/terms-conditions', [FrontendController::class, 'TermsConditions'])->name('terms.conditions');

    // About Us
    Route::get('/about-us', [FrontendController::class, 'AboutUs'])->name('about');

    // Search
    Route::get('/ajax-search', [FrontendController::class, 'ajaxSearch'])->name('ajax.search');

    // Child Development
    Route::get('/child-development', [FrontendController::class, 'ChildDevelopment'])->name('child.development');

    // Flash Sale
    Route::get('/excess-inventory', [FrontendController::class, 'FlashSale'])->name('flash.sale');

    // IT Product
    Route::get('/it-product', [FrontendController::class, 'ItProduct'])->name('it.product');

    // IT Product
    Route::get('/brands', [FrontendController::class, 'Brands'])->name('brands');

    // PDF Download — must be BEFORE /product/{slug}
    Route::get('/product/pdf/download/{id}', function ($id) {
        $product = \App\Models\Product::findOrFail($id);

        if (empty($product->flash_sale_pdf)) {
            abort(404);
        }

        $filePath = public_path($product->flash_sale_pdf);

        if (!file_exists($filePath)) {
            abort(404, 'PDF file not found.');
        }

        $fileName = basename($filePath);

        return response()->download($filePath, $fileName, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    })->name('product.pdf.download');

    // Product Details — এটা নিচে থাকবে
    Route::get('/product/{slug}', [FrontendController::class, 'ProductDetails'])->name('product.details');

    // AJAX Search Route
    Route::get('/ajax/search', [ProductController::class, 'ajaxSearch'])->name('ajax.search');

    // AJAX Default Products Route
    Route::get('/ajax/products', [ProductController::class, 'ajaxProducts'])->name('ajax.products');

    Route::get('/ajax/flash-sale', [ProductController::class, 'ajaxFlashSale'])->name('ajax.flash.sale');

    // Battery Frontend
    Route::get('/battery-management', [BatteryModuleController::class, 'frontend'])->name('frontend.battery');
    Route::get('/battery-management/search', [BatteryModuleController::class, 'ajaxSearch'])->name('frontend.battery.search');
});

// #################### End: Frontend Controller ####################

require __DIR__ . '/auth.php';

// #################### Admin Controller ####################
Route::middleware('admin')->group(function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');

    // Admin Profile
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');

    // Slider Controller
    Route::get('/backend/slider/list', [SliderController::class, 'SliderList'])->name('backend.slider.list');
    Route::get('/backend/slider/add', [SliderController::class, 'SliderAdd'])->name('backend.slider.add');
    Route::post('/backend/slider/store', [SliderController::class, 'SliderStore'])->name('backend.slider.store');
    Route::get('/backend/slider/edit/{id}', [SliderController::class, 'SliderEdit'])->name('backend.slider.edit');
    Route::post('/backend/slider/update', [SliderController::class, 'SliderUpdate'])->name('backend.slider.update');
    Route::get('/backend/slider/delete/{id}', [SliderController::class, 'SliderDelete'])->name('backend.slider.delete');

    // Product Brand
    Route::get('/backend/product-brand/list', [ProductBrandController::class, 'ProductBrandList'])->name('backend.product_brand.list');
    Route::get('/backend/product-brand/add', [ProductBrandController::class, 'ProductBrandAdd'])->name('backend.product_brand.add');
    Route::post('/backend/product-brand/store', [ProductBrandController::class, 'ProductBrandStore'])->name('backend.product_brand.store');
    Route::get('/backend/product-brand/edit/{id}', [ProductBrandController::class, 'ProductBrandEdit'])->name('backend.product_brand.edit');
    Route::post('/backend/product-brand/update', [ProductBrandController::class, 'ProductBrandUpdate'])->name('backend.product_brand.update');
    Route::get('/backend/product-brand/delete/{id}', [ProductBrandController::class, 'ProductBrandDelete'])->name('backend.product_brand.delete');

    // Product Categories
    Route::get('/backend/product-categories/list', [ProductCategoryController::class, 'ProductCategoriesList'])->name('backend.product_categories.list');
    Route::get('/backend/product-categories/add', [ProductCategoryController::class, 'ProductCategoriesAdd'])->name('backend.product_categories.add');
    Route::post('/backend/product-categories/store', [ProductCategoryController::class, 'ProductCategoriesStore'])->name('backend.product_categories.store');
    Route::get('/backend/product-categories/edit/{id}', [ProductCategoryController::class, 'ProductCategoriesEdit'])->name('backend.product_categories.edit');
    Route::post('/backend/product-categories/update', [ProductCategoryController::class, 'ProductCategoriesUpdate'])->name('backend.product_categories.update');
    Route::get('/backend/product-categories/delete/{id}', [ProductCategoryController::class, 'ProductCategoriesDelete'])->name('backend.product_categories.delete');

    // Product SubCategories
    Route::get('/backend/product-subcategories/list', [ProductSubCategoryController::class, 'ProductSubCategoriesList'])->name('backend.product_subcategories.list');
    Route::get('/backend/product-subcategories/add', [ProductSubCategoryController::class, 'ProductSubCategoriesAdd'])->name('backend.product_subcategories.add');
    Route::post('/backend/product-subcategories/store', [ProductSubCategoryController::class, 'ProductSubCategoriesStore'])->name('backend.product_subcategories.store');
    Route::get('/backend/product-subcategories/edit/{id}', [ProductSubCategoryController::class, 'ProductSubCategoriesEdit'])->name('backend.product_subcategories.edit');
    Route::post('/backend/product-subcategories/update', [ProductSubCategoryController::class, 'ProductSubCategoriesUpdate'])->name('backend.product_subcategories.update');
    Route::get('/backend/product-subcategories/delete/{id}', [ProductSubCategoryController::class, 'ProductSubCategoriesDelete'])->name('backend.product_subcategories.delete');
    Route::get('/backend/product-subcategories/by-category', [ProductSubCategoryController::class, 'getByCategory'])->name('backend.product_subcategories.by.category');

    // Age Group
    Route::get('/backend/age-group/list', [AgeGroupController::class, 'AgeGroupList'])->name('age_group.list');
    Route::get('/backend/age-group/add', [AgeGroupController::class, 'AgeGroupAdd'])->name('age_group.add');
    Route::post('/backend/age-group/store', [AgeGroupController::class, 'AgeGroupStore'])->name('age_group.store');
    Route::get('/backend/age-group/edit/{id}', [AgeGroupController::class, 'AgeGroupEdit'])->name('age_group.edit');
    Route::post('/backend/age-group/update', [AgeGroupController::class, 'AgeGroupUpdate'])->name('age_group.update');
    Route::get('/backend/age-group/delete/{id}', [AgeGroupController::class, 'AgeGroupDelete'])->name('age_group.delete');

    // Products
    Route::get('/backend/products/list', [ProductController::class, 'ProductList'])->name('backend.products.list');
    Route::get('/backend/products/add', [ProductController::class, 'ProductAdd'])->name('backend.products.add');
    Route::post('/backend/products/store', [ProductController::class, 'ProductStore'])->name('backend.products.store');
    Route::get('/backend/products/edit/{id}', [ProductController::class, 'ProductEdit'])->name('backend.products.edit');
    Route::post('/backend/products/update', [ProductController::class, 'ProductUpdate'])->name('backend.products.update');
    Route::get('/backend/products/delete/{id}', [ProductController::class, 'ProductDelete'])->name('backend.products.delete');
    // Product Gallery (Individual)
    Route::post('/backend/product/gallery/update/{id}', [ProductController::class, 'ProductGalleryUpdate'])->name('backend.product.gallery.update');
    Route::delete('/backend/product/gallery/delete/{id}', [ProductController::class, 'ProductGalleryDelete'])->name('backend.product.gallery.delete');
    Route::post('/backend/product/gallery/add', [ProductController::class, 'ProductGalleryAdd'])->name('backend.product.gallery.add');

    // IT Product Categories
    Route::get('/backend/it-categories/list', [ItProductCategoryController::class, 'List'])->name('backend.it_categories.list');
    Route::get('/backend/it-categories/add', [ItProductCategoryController::class, 'Add'])->name('backend.it_categories.add');
    Route::post('/backend/it-categories/store', [ItProductCategoryController::class, 'Store'])->name('backend.it_categories.store');
    Route::get('/backend/it-categories/edit/{id}', [ItProductCategoryController::class, 'Edit'])->name('backend.it_categories.edit');
    Route::post('/backend/it-categories/update', [ItProductCategoryController::class, 'Update'])->name('backend.it_categories.update');
    Route::get('/backend/it-categories/delete/{id}', [ItProductCategoryController::class, 'Delete'])->name('backend.it_categories.delete');

    // Bulk Orders
    Route::get('/backend/bulk-order/list', [BulkOrderController::class, 'BulkOrderList'])->name('backend.bulk_order.list');
    Route::get('/backend/bulk-order/delete/{id}', [BulkOrderController::class, 'BulkOrderDelete'])->name('backend.bulk_order.delete');
    Route::delete('/backend/bulk-order/bulk-delete', [BulkOrderController::class, 'BulkOrderBulkDelete'])->name('backend.bulk_order.bulk_delete');

    // Product Reviews
    Route::get('/product-review/list', [ProductReviewController::class, 'ProductReviewList'])->name('product_review.list');
    Route::post('/product-review/update-status', [ProductReviewController::class, 'updateStatus'])->name('product_review.update_status');
    Route::get('/product-review/delete/{id}', [ProductReviewController::class, 'ProductReviewDelete'])->name('product_review.delete');
    Route::post('/product-review/bulk-delete', [ProductReviewController::class, 'ProductReviewBulkDelete'])->name('product_review.bulk_delete');

    // About Our Company
    Route::get('/backend/about-company/list', [AboutCompanyController::class, 'AboutCompanyList'])->name('backend.about_company.list');
    Route::get('/backend/about-company/edit/{id}', [AboutCompanyController::class, 'AboutCompanyEdit'])->name('backend.about_company.edit');
    Route::post('/backend/about-company/update', [AboutCompanyController::class, 'AboutCompanyUpdate'])->name('backend.about_company.update');

    // Mission, Vision, Values
    Route::get('/backend/mission-vision-values/list', [MissionVisionController::class, 'MissionVisionList'])->name('backend.mission_vision.list');
    Route::get('/backend/mission-vision-values/edit/{id}', [MissionVisionController::class, 'MissionVisionEdit'])->name('backend.mission_vision.edit');
    Route::post('/backend/mission-vision-values/update', [MissionVisionController::class, 'MissionVisionUpdate'])->name('backend.mission_vision.update');

    // Blog Categories
    Route::get('/backend/blog-categories/list', [BlogCategoriesController::class, 'BlogCategoriesList'])->name('backend.blog_categories.list');
    Route::get('/backend/blog-categories/add', [BlogCategoriesController::class, 'BlogCategoriesAdd'])->name('backend.blog_categories.add');
    Route::post('/backend/blog-categories/store', [BlogCategoriesController::class, 'BlogCategoriesStore'])->name('backend.blog_categories.store');
    Route::get('/backend/blog-categories/edit/{id}', [BlogCategoriesController::class, 'BlogCategoriesEdit'])->name('backend.blog_categories.edit');
    Route::post('/backend/blog-categories/update', [BlogCategoriesController::class, 'BlogCategoriesUpdate'])->name('backend.blog_categories.update');
    Route::get('/backend/blog-categories/delete/{id}', [BlogCategoriesController::class, 'BlogCategoriesDelete'])->name('backend.blog_categories.delete');

    // Blog
    Route::get('/backend/blog/list', [BlogController::class, 'BlogList'])->name('backend.blog.list');
    Route::get('/backend/blog/add', [BlogController::class, 'BlogAdd'])->name('backend.blog.add');
    Route::post('/backend/blog/store', [BlogController::class, 'BlogStore'])->name('backend.blog.store');
    Route::get('/backend/blog/edit/{id}', [BlogController::class, 'BlogEdit'])->name('backend.blog.edit');
    Route::post('/backend/blog/update', [BlogController::class, 'BlogUpdate'])->name('backend.blog.update');
    Route::get('/backend/blog/delete/{id}', [BlogController::class, 'BlogDelete'])->name('backend.blog.delete');

    // Contact Form
    Route::get('/backend/contact-form/list', [ContactFormController::class, 'ContactFormList'])->name('backend.contact_form.list');
    Route::get('/backend/contact-form/delete/{id}', [ContactFormController::class, 'ContactFormDelete'])->name('backend.contact_form.delete');
    Route::post('/backend/contact-form/bulk-delete', [ContactFormController::class, 'ContactFormBulkDelete'])->name('backend.contact_form.bulk_delete');

    // Certificate Controller
    Route::get('/backend/certificate/list', [CertificateController::class, 'CertificateList'])->name('backend.certificate.list');
    Route::get('/backend/certificate/add', [CertificateController::class, 'CertificateAdd'])->name('backend.certificate.add');
    Route::post('/backend/certificate/store', [CertificateController::class, 'CertificateStore'])->name('backend.certificate.store');
    Route::get('/backend/certificate/edit/{id}', [CertificateController::class, 'CertificateEdit'])->name('backend.certificate.edit');
    Route::post('/backend/certificate/update', [CertificateController::class, 'CertificateUpdate'])->name('backend.certificate.update');
    Route::get('/backend/certificate/delete/{id}', [CertificateController::class, 'CertificateDelete'])->name('backend.certificate.delete');

    // Backend Battery Module
    Route::prefix('backend/battery')
        ->name('backend.battery.')
        ->group(function () {
            Route::get('/list', [BatteryModuleController::class, 'BatteryList'])->name('list');
            Route::get('/add', [BatteryModuleController::class, 'BatteryAdd'])->name('add');
            Route::post('/store', [BatteryModuleController::class, 'BatteryStore'])->name('store');
            Route::get('/edit/{id}', [BatteryModuleController::class, 'BatteryEdit'])->name('edit');
            Route::post('/update', [BatteryModuleController::class, 'BatteryUpdate'])->name('update');
            Route::get('/delete/{id}', [BatteryModuleController::class, 'BatteryDelete'])->name('delete');

            Route::get('/ad/list', [BatteryModuleController::class, 'BatteryAdList'])->name('ad.list');
            Route::get('/ad/add', [BatteryModuleController::class, 'BatteryAdAdd'])->name('ad.add');
            Route::post('/ad/store', [BatteryModuleController::class, 'BatteryAdStore'])->name('ad.store');
            Route::get('/ad/edit/{id}', [BatteryModuleController::class, 'BatteryAdEdit'])->name('ad.edit');
            Route::post('/ad/update', [BatteryModuleController::class, 'BatteryAdUpdate'])->name('ad.update');
            Route::get('/ad/delete/{id}', [BatteryModuleController::class, 'BatteryAdDelete'])->name('ad.delete');
        });

    // Battery Categories
    Route::get('/backend/battery-category/list', [BatteryCategoryController::class, 'List'])->name('backend.battery_category.list');
    Route::get('/backend/battery-category/add', [BatteryCategoryController::class, 'Add'])->name('backend.battery_category.add');
    Route::post('/backend/battery-category/store', [BatteryCategoryController::class, 'Store'])->name('backend.battery_category.store');
    Route::get('/backend/battery-category/edit/{id}', [BatteryCategoryController::class, 'Edit'])->name('backend.battery_category.edit');
    Route::post('/backend/battery-category/update', [BatteryCategoryController::class, 'Update'])->name('backend.battery_category.update');
    Route::get('/backend/battery-category/delete/{id}', [BatteryCategoryController::class, 'Delete'])->name('backend.battery_category.delete');

    // Font Awesome
    Route::get('/backend/site-settings/font-awesome', [SiteSettingsController::class, 'FontAwesome'])->name('backend.site_settings.font_awesome');

    // Site Settings
    Route::get('/backend/site-settings', [SiteSettingsController::class, 'SiteSettings'])->name('backend.site_settings');
    Route::post('/backend/site-settings/update', [SiteSettingsController::class, 'SiteSettingsUpdate'])->name('backend.site_settings.update');

    // Status Update
    Route::post('/backend/status-update', [GlobalController::class, 'StatusUpdate'])->name('backend.status.update');

    // ✅ Admin custom 404
    Route::fallback(function () {
        return response()->view('admin.errors.404', [], 404);
    });
});

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
Route::post('/admin/login/submit', [AdminController::class, 'AdminLoginSubmit'])->name('admin.login.submit');
Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
Route::get('/admin/forget/password', [AdminController::class, 'AdminForgetPassword'])->name('admin.forget.password');
Route::post('/admin/forget/password/submit', [AdminController::class, 'AdminForgetPasswordSubmit'])->name('admin.forget.password.submit');
Route::get('/admin/reset/password/{token}/{email}', [AdminController::class, 'AdminResetPassword']);
Route::post('/admin/forget/reset/submit', [AdminController::class, 'AdminResetPasswordSubmit'])->name('admin.reset.password.submit');
// #################### End: Admin Controller ####################

/*
|--------------------------------------------------------------------------
| Customer Authentication
|--------------------------------------------------------------------------
*/

Route::get('/account/login', [CustomerAuthController::class, 'login'])->name('customer.login');

Route::post('/account/login/submit', [CustomerAuthController::class, 'loginSubmit'])->name('customer.login.submit');

Route::get('/account/register', [CustomerAuthController::class, 'register'])->name('customer.register');

Route::post('/account/register/submit', [CustomerAuthController::class, 'registerSubmit'])->name('customer.register.submit');

Route::get('/account/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');

/*
|--------------------------------------------------------------------------
| Protected Customer Routes
|--------------------------------------------------------------------------
*/
Route::middleware('customer')->group(function () {
    Route::get('/user/dashboard', [CustomerAuthController::class, 'dashboard'])->name('customer.dashboard');

    // Route::get('/customer/profile', [CustomerAuthController::class, 'profile'])->name('customer.profile');

    Route::post('/user/profile/update', [CustomerAuthController::class, 'profileUpdate'])->name('customer.profile.update');
    Route::post('/user/change/password', [CustomerAuthController::class, 'changePassword'])->name('customer.password.change');
});

// ✅ ADMIN 404 for any /admin/* (must be before global fallback)
Route::get('/admin/{any}', function () {
    return response()->view('admin.errors.404', [], 404);
})->where('any', '.*');

// ✅ Frontend custom 404 (must be last)
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
