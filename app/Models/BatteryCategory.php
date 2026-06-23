<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BatteryCategory extends Model
{
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class, 'battery_category_id');
    }

    // Auto slug generate
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }
}
