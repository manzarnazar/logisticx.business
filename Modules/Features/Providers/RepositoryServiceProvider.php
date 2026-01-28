<?php

namespace Modules\Features\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Features\Repositories\Features\FeaturesInterface;
use Modules\Features\Repositories\Features\FeaturesRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FeaturesInterface::class,             FeaturesRepository::class);
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
