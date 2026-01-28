<?php

namespace Modules\Client\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Client\Repositories\Client\ClientInterface;
use Modules\Client\Repositories\Client\ClientRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClientInterface::class,             ClientRepository::class);
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
