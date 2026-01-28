<?php

namespace Modules\HR\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\HR\Repositories\Holiday\HolidayInterface;
use Modules\HR\Repositories\Holiday\HolidayRepository;
use Modules\HR\Repositories\Weekend\WeekendInterface;
use Modules\HR\Repositories\Weekend\WeekendRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(WeekendInterface::class,           WeekendRepository::class);
        $this->app->bind(HolidayInterface::class,           HolidayRepository::class);
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
