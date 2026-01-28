<?php

namespace App\Repositories\ValueAddedService;


interface VASInterface
{
    public function all(bool $status = null, array $column = [], int $paginate = null, $orderBy = 'position');

    public function get($id);

    public function store($request);

    public function update($request);

    public function delete($id);

    public function getWithFilter($skipIDs = [], array $where = [], array $columns = ['*'], $retrieveFirst = false);
}
