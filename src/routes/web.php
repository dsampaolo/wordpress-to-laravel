<?php

$blog_url = config('wordpress-to-laravel.local_blog_path');

Route::get(config('wordpress-to-laravel.url_rss'), 'BlogController@feed')->name('wordpress-to-laravel.blog.feed')->middleware('web');

Route::get($blog_url, 'BlogController@index')->name('wordpress-to-laravel.blog.show')->middleware('web');
Route::get($blog_url.'/{category}', 'BlogController@category')->name('wordpress-to-laravel.blog.category.show')->middleware('web');
Route::get($blog_url.'/{category}/{post}', 'BlogController@post')->name('wordpress-to-laravel.blog.post.show')->middleware('web');