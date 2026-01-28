<?php

namespace App\Repositories\MerchantShops;

interface ShopsInterface
{

    public function all();
    public function get($id);
    public function store($request);
    public function update($request);
    public function delete($id);
    public function defaultShop($merchant_id, $id);
    public function merchantShopsGet(int $merchant_id, bool $status = null, int $paginate = null);
    public function getMerchantShopDetails($merchantId, $shopId);
}
