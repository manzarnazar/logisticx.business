<?php

namespace Modules\Team\Repositories;

interface TeamInterface
{

    public function all(string $orderBy = 'id', string $sortBy = 'desc');
    public function activeAll(string $orderBy = 'position', string $sortBy = 'asc');
    public function get($id);
    public function store($request);
    public function update($request, $id);
    public function delete($id);
    public function statusUpdate($id);
}
