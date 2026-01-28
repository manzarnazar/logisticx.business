<?php

namespace Modules\Blog\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Blog\Repositories\Blog\BlogInterface;
use Modules\Blog\Repositories\Blog\BlogRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BlogInterface::class,           BlogRepository::class);
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
