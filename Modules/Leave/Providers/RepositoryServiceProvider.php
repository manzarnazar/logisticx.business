<?php

namespace Modules\Leave\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Leave\Repositories\LeaveType\LeaveTypeInterface;
use Modules\Leave\Repositories\LeaveType\LeaveTypeRepository;
use Modules\Leave\Repositories\LeaveAssign\LeaveAssignInterface;
use Modules\Leave\Repositories\LeaveAssign\LeaveAssignRepository;
use Modules\Leave\Repositories\LeaveRequest\LeaveRequestInterface;
use Modules\Leave\Repositories\LeaveRequest\LeaveRequestRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LeaveTypeInterface::class , LeaveTypeRepository::class);
        $this->app->bind(LeaveAssignInterface::class , LeaveAssignRepository::class);
        $this->app->bind(LeaveRequestInterface::class , LeaveRequestRepository::class);
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
