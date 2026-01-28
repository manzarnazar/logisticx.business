<?php

namespace App\Repositories\Coupon;

interface CouponInterface
{
    public function all(array $column = [], int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc');

    public function get($id);

    public function store($request);

    public function update($request);

    public function delete($id);
}
