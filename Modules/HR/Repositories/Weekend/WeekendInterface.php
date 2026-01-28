<?php

namespace Modules\HR\Repositories\Weekend;

interface WeekendInterface
{

    public function all(string $orderBy = 'id', string $sortBy = 'desc');
    public function get($id);
    public function update($request);
}
