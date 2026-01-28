<?php

namespace App\Repositories\HeroApp;

interface HeroAppInterface
{
    public function parcels(array $status = null, int $paginate = null);

    public function singleParcel(int $id = null, string $tracking_id = null);

    public function dashboardData(): array;

    public function heroPayments($payment_status = null, int $paginate = null);

    public function requestParcelDelivery($request);
}
