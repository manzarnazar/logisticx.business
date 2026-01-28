<?php

namespace Modules\Gallery\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Gallery\Repositories\GalleryInterface;
use Modules\Gallery\Repositories\GalleryRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->bind(GalleryInterface::class,           GalleryRepository::class);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
