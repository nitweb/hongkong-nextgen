<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_brand_id');
    }
}
