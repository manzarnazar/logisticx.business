<?php

namespace App\Repositories\MerchantPanel\Shops;

interface ShopsInterface
{

    public function all($merchant_id, string $orderBy = 'id', string $sortBy = 'desc');
    public function get($id);
    public function store($id, $request);
    public function update($id, $request);
    public function delete($id);
    public function getMerchant($id);
    public function defaultShop($id);
}
