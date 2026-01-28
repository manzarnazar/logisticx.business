<?php

namespace Modules\Language\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Language\Repositories\Language\LanguageInterface;
use Modules\Language\Repositories\Language\LanguageRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind(LanguageInterface::class,    LanguageRepository::class);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
