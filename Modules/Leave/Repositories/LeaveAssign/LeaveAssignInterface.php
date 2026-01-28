<?php

namespace Modules\Leave\Repositories\LeaveAssign;

interface LeaveAssignInterface
{
    public function all(int $status = null, int $paginate = null, string $orderBy = 'id', $sortBy = 'desc');
    public function activeLeaveAssign();
    public function find($id);
    public function store($request);
    public function update($request);
    public function delete($id);
}
