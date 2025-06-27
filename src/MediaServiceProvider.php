<?php

namespace Bakkali\Media;

use Illuminate\Support\ServiceProvider;

class MediaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish migration
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'media-migrations');
    }

    public function register()
    {
        //
    }
}
