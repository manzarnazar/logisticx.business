<?php

namespace App\Repositories\DeliveryMan;

interface DeliveryManInterface
{
    public function all(bool $status = null, int $paginate = null, string $orderBy = 'id', $sortBy = 'desc');
    public function hubs();
    public function get($id);
    public function filter($request);
    public function store($request);
    public function update($id, $request);
    public function delete($id);
    public function paymentLogs();
    public function searchHero($request);
}
