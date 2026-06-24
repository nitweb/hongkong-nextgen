<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_it_product' => 'boolean',
        'is_battery' => 'boolean',
        'product_price' => 'decimal:2',
        'discount_price' => 'decimal:2',
    ];

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function itCategory()
    {
        return $this->belongsTo(ItProductCategory::class, 'it_category_id');
    }

    public function batteryCategory()
    {
        return $this->belongsTo(BatteryCategory::class, 'battery_category_id');
    }

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class, 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id')->latest();
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class, 'product_id')->orderBy('sort_order');
    }

    public function scopeItProduct($query)
    {
        return $query->where('is_it_product', true);
    }

    public function scopeBattery($query)
    {
        return $query->where('is_battery', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_status', 'in_stock');
    }

    public function relatedProducts()
    {
        return $this->belongsToMany(Product::class, 'product_related', 'product_id', 'related_product_id')->where('status', 'active')->withTimestamps();
    }
}
