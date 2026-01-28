<?php

namespace App\Repositories\PickupSlot;

interface PickupSlotInterface
{
    public function all(int $status = null, array $column = [], int $paginate = null, string $orderBy = 'position');

    public function get($id);

    public function store($request);

    public function update($request);

    public function delete($id);
}
