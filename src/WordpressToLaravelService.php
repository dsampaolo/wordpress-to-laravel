<?php

namespace dsampaolo\WordpressToLaravel;

use Illuminate\Support\Carbon;
use dsampaolo\WordpressToLaravel\Models\Post;
use dsampaolo\WordpressToLaravel\Models\Category;

class WordpressToLaravelService
{
    protected $blog_url;
    protected $api_url;
    protected $img_storage_path;

    public function __construct($config)
    {
        $this->blog_url         = $config['wordpress-to-laravel']['source_blog_url'];
        $this->category_id      = $config['wordpress-to-laravel']['source_category_id'];
        $this->img_storage_path = $config['wordpress-to-laravel']['local_img_storage_path'];
        $this->api_url          = $this->blog_url . '/wp-json/wp/v2/';
    }

    public function importPosts($page = 1)
    {
        $posts = collect($this->getJson($this->api_url . 'posts/?_embed&categories=' . $this->category_id . '&filter[orderby]=modified&page=' . $page));
        foreach ($posts as $post) {
            echo $post->title->rendered . '<br />';
            $this->syncPost($post);
        }
    }

    protected function getJson($url)
    {
        $response = file_get_contents($url, false);

        return json_decode($response);
    }

    protected function syncPost($data)
    {
        $found = Post::where('wp_id', $data->id)->first();

        if ( ! $found) {
            return $this->createPost($data);
        }

        if ($found and $found->updated_at->format("Y-m-d H:i:s") < $this->carbonDate($data->modified)->format("Y-m-d H:i:s")) {
            return $this->updatePost($found, $data);
        }
    }

    protected function carbonDate($date)
    {
        return Carbon::parse($date);
    }

    protected function createPost($data)
    {
        $featured_image = $this->featuredImage($data->_embedded);
        $featured_local = $this->downloadImage($featured_image);

        $post        = new Post();
        $post->id    = $data->id;
        $post->wp_id = $data->id;
//        $post->user_id = $this->getAuthor($data->_embedded->author);
        $post->title                 = $data->title->rendered;
        $post->slug                  = $data->slug;
        $post->featured_image_remote = $featured_image;
        $post->featured_image        = $featured_local;
        $post->featured              = ($data->sticky) ? 1 : null;
        $post->excerpt               = $data->excerpt->rendered;
        $post->content               = $data->content->rendered;
        $post->format                = $data->format;
        $post->status                = 'publish';
        $post->published_at          = $this->carbonDate($data->date);
        $post->created_at            = $this->carbonDate($data->date);
        $post->updated_at            = $this->carbonDate($data->modified);
        $post->category_id           = $this->getCategory($data->_embedded->{"wp:term"});
        $post->save();
        $this->syncTags($post, $data->_embedded->{"wp:term"});

        return $post;
    }

    protected function downloadImage($featured_image)
    {
        $featured_local = null;

        if ($featured_image) {
            $featured_name = basename($featured_image);
            @mkdir($this->img_storage_path, 0755, true);
            $featured_path = $this->img_storage_path . '/' . $featured_name;
            if ( ! is_file($featured_path)) {
                copy($featured_image, $featured_path);
            }
            $featured_local = $featured_name;
        }

        return $featured_local;
    }

    protected function updatePost(Post $post, $data)
    {
        $featured_image = $this->featuredImage($data->_embedded);
        $featured_local = $this->downloadImage($featured_image);

        $post->title                 = $data->title->rendered;
        $post->slug                  = $data->slug;
        $post->featured_image_remote = $featured_image;
        $post->featured_image        = $featured_local;
        $post->featured              = ($data->sticky) ? 1 : null;
        $post->excerpt               = $data->excerpt->rendered;
        $post->content               = $data->content->rendered;
        $post->format                = $data->format;
        $post->status                = 'publish';
        $post->published_at          = $this->carbonDate($data->date);
        $post->created_at            = $this->carbonDate($data->date);
        $post->updated_at            = $this->carbonDate($data->modified);
        $post->category_id           = $this->getCategory($data->_embedded->{"wp:term"});
        $post->save();

        $this->syncTags($post, $data->_embedded->{"wp:term"});
    }

    public function featuredImage($data)
    {
        if (property_exists($data, "wp:featuredmedia")) {
            $data = head($data->{"wp:featuredmedia"});
            if (isset($data->source_url)) {
                return $data->source_url;
            }
        }

        return null;
    }

    public function getCategory($data)
    {
        $category = collect($data)
            ->collapse()
            ->where('taxonomy', 'category')
            ->where('id', '!=', $this->category_id)
            ->first();

        if ( ! $category) {
            return null;
        }

        $found = Category::where('wp_id', $category->id)->first();
        if ($found) {
            return $found->id;
        }
        $cat              = new Category();
        $cat->id          = $category->id;
        $cat->wp_id       = $category->id;
        $cat->name        = $category->name;
        $cat->slug        = $category->slug;
        $cat->description = '';
        $cat->save();

        return $cat->id;
    }

    private function syncTags(Post $post, $tags)
    {
        $tags = collect($tags)->collapse()->where('taxonomy', 'post_tag')->pluck('name')->toArray();
        if (count($tags) > 0) {
//            $post->setTags($tags);
        }
    }
}