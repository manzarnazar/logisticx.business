<?php

namespace Modules\DeliveryArea\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\DeliveryArea\Repositories\DeliveryAreaInterface;
use Modules\DeliveryArea\Repositories\DeliveryAreaRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        //public function register()
        {
            $this->app->bind(DeliveryAreaInterface::class, DeliveryAreaRepository::class);
        }
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
