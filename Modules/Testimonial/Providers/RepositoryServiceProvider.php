<?php

namespace Modules\Testimonial\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Testimonial\Repositories\TestimonialInterface;
use Modules\Testimonial\Repositories\TestimonialRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TestimonialInterface::class,                TestimonialRepository::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function boot()
    {
        //
    }
}
