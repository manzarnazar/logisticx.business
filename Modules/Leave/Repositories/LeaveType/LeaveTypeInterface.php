<?php

namespace Modules\Leave\Repositories\LeaveType;

interface LeaveTypeInterface
{

    public function all(string $orderBy = 'id', string $sortBy = 'desc');
    public function activeLeaveType();
    public function find($id);
    public function store($request);
    public function update($request);
    public function delete($id);
    public function statusUpdate($id);

    public function getWithFilter(array $where = [], array $columns = ['*'],  int $paginate = null);
}
