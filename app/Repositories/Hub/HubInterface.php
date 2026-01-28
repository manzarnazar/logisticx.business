<?php

namespace App\Repositories\Hub;

interface HubInterface
{

    public function all(bool $status = null, string $orderBy = 'id', string $sortBy = 'desc', int $paginate = null);
    public function filter($request, int $paginate = null);
    public function hubs();
    public function get($id);
    public function store($request);
    public function update($id, $request);
    public function delete($id);
}
