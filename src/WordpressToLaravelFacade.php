<?php

namespace dsampaolo\WordpressToLaravel;

use Illuminate\Support\Facades\Facade;

class WordpressToLaravelFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'wordpress-to-laravel';
    }
}