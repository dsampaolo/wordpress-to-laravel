# Purpose
The purpose of this package is to allow you to duplicate an existing Wordpress blog into a Laravel application. It is not a full blog package, it doesn't have a backend. You will have to publish your posts to an existing Wordpress and then sync them to your Laravel app.

# Getting started

## Install the package using Composer

`composer require dsampaolo/wordpress-to-laravel`

## Publish assets (views and configuration file)

`php artisan vendor:publish`

## Configuration

Edit your .env file (or the package's configuration file) to match your desired configuration :

- WP2LV_BLOG_URL : URL of the remote blog
- WP2LV_CATEGORY_ID : ID of the category to replicate (parent)
- WP2LV_RSS_URL : URL of the RSS feed for your Laravel application 
- WP2LV_LOCAL_BLOG_PATH : URL of the homepage of the blog on your Laravel app
  
In the configuration file, you will also find a local_img_storage_path variable, which defines the path where the post's images will be saved. 
  
That's it. Go to http://example.org/blog to visit your blog.

# What it can/can't do
This package will replicate all posts in ONE category of your Wordpress remote blog to your Laravel app.
Eaech post can be in only ONE sub-category of the parent category.

Example :
Let's say your Laravel App is named A.
Your blog posts MUST be in A/First Cat or A/Second Cat in order for them to be synced. Also, they must be published.

The package will download images (featured and inside the post) to your app's server, and change URLs inside the post accordingly.

Your blog will extend layouts.app - feel free to edit your blog's views if you use something else.

This package doesn't sync posts automatically. You have to launch the importer manually.

# See also

- https://laravel-news.com/wordpress-api-with-laravel
- https://laravel.com/docs/5.6/packages#service-providers
- https://medium.com/@markustripp/laravel-5-5-package-development-e72f3e7a8f38
