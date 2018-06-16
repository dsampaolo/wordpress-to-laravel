<?php

namespace dsampaolo\WordpressToLaravel;

use Illuminate\Support\ServiceProvider;

class WordpressToLaravelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/wordpress-to-laravel.php' => config_path('wordpress-to-laravel.php'),
        ], 'wordpress-to-laravel');

        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/wordpress-to-laravel.php', 'wordpress-to-laravel');

        $this->app->singleton('wordpress-to-laravel', function($app) {
            $config = $app->make('config');
            return new WordpressToLaravelService($config);
        });
    }

    public function provides()
    {
        return ['wordpress-to-laravel'];
    }
}