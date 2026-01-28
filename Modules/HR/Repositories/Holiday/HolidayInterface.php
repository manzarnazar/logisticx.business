<?php

namespace Modules\HR\Repositories\Holiday;

interface HolidayInterface
{

    public function all(bool $status = null, int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc');
    public function get($id);
    public function store($request);
    public function update($request);
    public function delete($id);
}
