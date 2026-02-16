<?php

namespace App\Providers;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Header menu te active categories auto share
        View::composer('frontend.layout.header', function ($view) {
            $header_categories = ProductCategory::where('product_category_status', 'active')->orderBy('product_category_name')->get();

            $view->with('header_categories', $header_categories);
        });
    }
}
