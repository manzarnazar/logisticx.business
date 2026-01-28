<?php

namespace App\Repositories\MerchantManage\Payment;

interface PaymentInterface
{
    public function all($merchant_id = null, string $orderBy = 'id', string $sortBy = 'desc', bool $get = false);
    public function get($id);
    public function store($request);
    public function update($request);
    public function delete($id);
    public function reject($id);
    public function cancelReject($id);
    public function processed($request);
    public function cancelProcess($id);
    public function filter($request);
}
