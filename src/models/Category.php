<?php

namespace dsampaolo\WordpressToLaravel\Models;

use \Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'post_categories';

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getUrlAttribute()
    {
        return url('/blog/' . $this->slug);
    }

    public function getImageAttribute()
    {
        return asset('storage/img/blog/' . $this->featured_image);
    }
}