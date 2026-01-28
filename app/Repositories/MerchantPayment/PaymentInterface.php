<?php

namespace App\Repositories\MerchantPayment;

interface PaymentInterface
{
    public function all(int $status = null, int $merchant_id = null, int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc');

    public function get($id);

    public function store($request);

    public function update($request);

    public function delete($id);
}
