<?php

namespace ktourvas\LaravelBlog;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class LaravelBlogServiceProvider extends ServiceProvider
{

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {

        if (! $this->app->routesAreCached()) {
            require __DIR__.'/routes/api.php';
        }

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../config/laravel-blog.php' => config_path('laravel-blog.php'),
        ]);

        Relation::morphMap([
            'BlogArticle' => 'ktourvas\LaravelBlog\Entities\Article',
//            'warehouses' => 'App\Warehouse',
        ]);

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
