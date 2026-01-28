<?php

namespace App\Repositories\HubManage\HubPayment;

interface HubPaymentInterface
{
    public function all(bool $status = null, int $paginate = null, string $orderBy = 'id', $sortBy = 'desc');

    public function get($id);

    public function store($request);

    public function update($request);

    public function delete($id);

    public function reject($id);

    public function cancelReject($id);

    public function processed($request);

    public function cancelProcess($id);
}
