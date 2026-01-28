<?php

namespace App\Repositories\Bank;

interface BankInterface
{

    public function all(bool $status = null, int $paginate = null, string $orderBy = 'id', $sortBy = 'desc');
    public function get($request);
    public function store($request);
    public function update($id, $request);
    public function delete($id);
}
