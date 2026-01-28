<?php

namespace Modules\Client\Repositories\Client;

interface ClientInterface
{

    public function all(string $orderBy = 'id', string $sortBy = 'desc');
    public function getActive(string $orderBy = 'position', string $sortBy = 'asc');
    public function getFind($id);
    public function store($request);
    public function update($request, $id);
    public function delete($id);
    public function statusUpdate($id);
}
