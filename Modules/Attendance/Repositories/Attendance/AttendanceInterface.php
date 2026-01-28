<?php

namespace Modules\Attendance\Repositories\Attendance;

interface AttendanceInterface
{

    public function all(int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc');
    public function get($id);
    public function getAttandancesForDownload($filteredIds);
    public function store($request);
    public function update($request);
    public function delete($id);
}
