<?php

namespace App\Repositories\AccountHeads;

use App\Enums\Status;

interface AccountHeadsInterface
{
    public function all(string $orderBy = 'id', string $sortBy = 'desc');
    public function getActive(string $orderBy = 'id', string $sortBy = 'asc', $head);
    public function get($id);
    public function store($request);
    public function update($id, $request);
    public function delete($id);
    public function getHeads($type = null,  bool $status = Status::ACTIVE, ?int $paginate = null);
}
