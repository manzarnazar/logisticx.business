<?php
namespace App\Repositories\MerchantPanel\PickupRequest;

Interface PickupRequestInterface {
    public function getRegular();
    public function getExpress();
    public function regularStore($request);
    public function expressStore($request);

    public function getList($request);
    public function store($request);

    public function delete($id);
}
