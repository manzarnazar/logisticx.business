<?php

namespace Modules\Team\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Team\Repositories\TeamInterface;
use Modules\Team\Repositories\TeamRepository;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TeamInterface::class, TeamRepository::class);
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
