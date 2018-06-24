<?php

return [
    'source_blog_url'        => env('WP2LV_BLOG_URL'),
    'source_category_id'     => env('WP2LV_CATEGORY_ID'),
    'local_img_storage_path' => storage_path('app/public/img/blog'),
    'url_rss'                => env('WP2LV_RSS_URL', '/feed'),
    'local_blog_path'        => env('WP2LV_LOCAL_BLOG_PATH', '/blog'),
];