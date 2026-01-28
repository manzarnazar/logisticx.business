<?php

namespace Modules\Attendance\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Attendance\Repositories\Attendance\AttendanceInterface;
use Modules\Attendance\Repositories\Attendance\AttendanceRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->bind(AttendanceInterface::class,    AttendanceRepository::class);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
