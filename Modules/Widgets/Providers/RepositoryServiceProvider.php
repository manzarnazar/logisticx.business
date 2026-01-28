<?php

namespace Modules\Widgets\Providers;


use Illuminate\Support\ServiceProvider;
use Modules\Widgets\Repositories\WidgetsInterface;
use Modules\Widgets\Repositories\WidgetsRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(WidgetsInterface::class, WidgetsRepository::class);
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
