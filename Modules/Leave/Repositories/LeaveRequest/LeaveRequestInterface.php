<?php

namespace Modules\Leave\Repositories\LeaveRequest;

interface LeaveRequestInterface
{

    public function all(string $orderBy = 'id', string $sortBy = 'desc');
    public function userReadOnly();
    public function activeLeaveRequest();
    public function find($id);
    public function store($request);
    public function update($request, $id);
    public function delete($id);
    public function requestpending($id, $request);
    public function requestApproved($id, $request);
    public function requestRejected($id, $request);
}
