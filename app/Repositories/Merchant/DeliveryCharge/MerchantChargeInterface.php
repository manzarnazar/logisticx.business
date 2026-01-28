<?php

namespace App\Repositories\Merchant\DeliveryCharge;

use App\Enums\Status;

interface MerchantChargeInterface
{
    public function all(int $merchant_id = null, int $status = null, array $column = [], int $paginate = null, string $orderBy = 'position', array $where = []);

    public function get(int $id);

    public function store($request);

    public function update($request);

    public function updateCodCharge($request, int $merchant_id);

    public function delete(int $id);

    public function singleCharge(int $charge_id = null, array $where = ['status' => Status::ACTIVE], array $columns = ['id', 'charge_id', 'delivery_time',  'charge', 'additional_charge']);
}
