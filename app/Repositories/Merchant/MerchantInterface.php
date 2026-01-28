<?php

namespace App\Repositories\Merchant;

interface MerchantInterface
{

    public function all(bool $status = null, int $paginate = null, string $orderBy = 'id', $sortBy = 'desc');
    public function merchantIdList();
    public function all_hubs();
    public function active_hubs();
    public function get($id);
    public function store($request);
    public function signUpStore($request);
    public function emailVerification($request);
    public function otpVerification($request);
    public function resendOTP($request);
    public function update($request);
    public function delete($id);
    public function merchant_shops_get($id);
    public function socialSignupStore($request, $social);
}
