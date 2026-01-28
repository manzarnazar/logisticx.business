<?php

namespace App\Repositories\Charge;

use App\Enums\Status;

interface ChargeInterface
{
    public function all(?bool $status = null, array $column = [], ?int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc');

    public function get($id);

    public function store($request);

    public function update($request);

    public function delete($id);

    public function getProductCategory(array $where = []);

    public function getServiceType(array $where = []);

    public function singleCharge(?int $id = null, array $where = ['status' => Status::ACTIVE], array $columns = ['id', 'delivery_time', 'charge', 'additional_charge']);

    public function getWithFilter(?string $with = null, $skipChargeIDs = [], array $where = [], array $columns = ['*'], $retrieveFirst = false);

    public function getHeroCharge($charge_id, $parcel_quantity = 1);
}
