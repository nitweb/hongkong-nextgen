<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $guarded = [];

    public function blogCategory()
    {
        return $this->belongsTo(BlogCategories::class, 'blog_category_id');
    }

    public function blogPublisher()
    {
        return $this->belongsTo(Admin::class, 'blog_published_by');
    }
}
