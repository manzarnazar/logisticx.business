<?php

namespace Modules\SocialLink\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\SocialLink\Repositories\SocialLinkInterface;
use Modules\SocialLink\Repositories\SocialLinkRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SocialLinkInterface::class, SocialLinkRepository::class);
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
