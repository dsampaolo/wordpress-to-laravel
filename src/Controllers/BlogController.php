<?php

namespace dsampaolo\WordpressToLaravel\Controllers;

use App\Http\Controllers\Controller;
use dsampaolo\WordpressToLaravel\Models\Category;
use dsampaolo\WordpressToLaravel\Models\Post;

class BlogController extends Controller
{
    public function feed()
    {
        $posts = Post::orderBy('published_at', 'desc')->take(10)->get();

        return view('wordpress-to-laravel::rss', ['posts' => $posts]);
    }

    public function index()
    {
        $posts = Post::orderBy('published_at', 'desc')->paginate(10);

        return view('wordpress-to-laravel::index', ['posts' => $posts]);
    }

    public function category(Category $category)
    {
        return view('wordpress-to-laravel::category', ['category' => $category]);
    }

    public function post(Category $category, Post $post)
    {
        return view('wordpress-to-laravel::post', ['post' => $post]);
    }
}