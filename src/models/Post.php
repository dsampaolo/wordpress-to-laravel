<?php

namespace dsampaolo\WordpressToLaravel\Models;

use \Illuminate\Database\Eloquent\Model;

class Post extends Model
{
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
}