<?php

namespace Modules\Section\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Section\Repositories\SectionInterface;
use Modules\Section\Repositories\SectionRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SectionInterface::class,  SectionRepository::class);
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
