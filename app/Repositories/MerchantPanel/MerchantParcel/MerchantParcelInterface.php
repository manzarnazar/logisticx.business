<?php

namespace App\Repositories\MerchantPanel\MerchantParcel;

interface MerchantParcelInterface
{

    public function all($merchant_id, string $orderBy = 'id', string $sortBy = 'desc', $status = null, $paginate = true);

    public function parcelAll($merchant_id);

    public function parcelBank($merchant_id, string $orderBy = 'id', string $sortBy = 'desc', $get = false);

    public function filter($merchant_id, $request);

    public function parcelEvents($id);

    public function get($id);

    public function details($id);

    public function delete($id, $merchant_id);

    public function getMerchant($id);

    public function getShop($id);

    public function getShops($id);

    public function parcelTrack($track_id);

    public function subscribe($request);

    public function parcelExport($request);
}
