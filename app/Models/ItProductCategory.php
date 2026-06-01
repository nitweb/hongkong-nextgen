<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItProductCategory extends Model
{
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class, 'it_category_id');
    }
}
