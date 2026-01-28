<?php

namespace Modules\Faq\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Faq\Repositories\FaqInterface;
use Modules\Faq\Repositories\FaqRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FaqInterface::class, FaqRepository::class);
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
