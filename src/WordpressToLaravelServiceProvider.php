<?php

namespace dsampaolo\WordpressToLaravel;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class WordpressToLaravelServiceProvider extends ServiceProvider
{
    public function boot(Router $router)
    {
        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        $this->mapRoutes($this->app->router);

        $this->loadViewsFrom(__DIR__ . '/views', 'wordpress-to-laravel');

        $this->publishes([
            __DIR__ . '/../config/wordpress-to-laravel.php' => config_path('wordpress-to-laravel.php'),
            __DIR__ . '/views'                              => resource_path('views/vendor/wordpress-to-laravel'),
        ], 'wordpress-to-laravel');
    }

    public function mapRoutes(Router $router)
    {
        $this->namespace = 'dsampaolo\WordpressToLaravel\Controllers';

        $router->group(['namespace' => $this->namespace], function ($router) {
            require(__DIR__ . '/routes/web.php');
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/wordpress-to-laravel.php', 'wordpress-to-laravel');

        $this->app->singleton('wordpress-to-laravel', function ($app) {
            $config = $app->make('config');

            return new WordpressToLaravelService($config);
        });
    }

    public function provides()
    {
        return ['wordpress-to-laravel'];
    }
}