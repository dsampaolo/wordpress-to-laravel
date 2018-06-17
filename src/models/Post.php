<?php

namespace dsampaolo\WordpressToLaravel\Models;

use \Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $dates = ['published_at'];

    protected $fillable = [
        'title',
        'slug',
        'featured_image_remote',
        'featured_image',
        'featured',
        'excerpt',
        'content',
        'format',
        'status',
        'published_at',
        'created_at',
        'updated_at',
        'category_id',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getUrlAttribute()
    {
        return url('/blog/'.$this->category->slug.'/'.$this->slug);
    }

    public function getImageAttribute()
    {
        return asset('storage/img/blog/'.$this->featured_image);
    }
}