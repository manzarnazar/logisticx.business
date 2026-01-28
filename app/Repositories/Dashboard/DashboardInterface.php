<?php

namespace App\Repositories\Dashboard;

interface DashboardInterface
{
    public function parcels(string $status = null, int $take = null, string $orderBy = 'updated_at', string $sortBy = 'desc');
}
