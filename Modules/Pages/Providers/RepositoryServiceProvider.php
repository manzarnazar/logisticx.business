<?php

namespace Modules\Pages\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Pages\Repositories\PagesInterface;
use Modules\Pages\Repositories\PagesRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PagesInterface::class, PagesRepository::class);
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
