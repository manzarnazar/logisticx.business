<?php

namespace App\Repositories\Coverage;


interface CoverageInterface
{
    public function all(array $column = [], ?int $paginate = null, string $orderBy = 'position', string $sortBy = 'desc', array $where = [], ?string $search = null);

    public function get(int $id);

    public function store($request);

    public function update($request);

    public function delete($id);

    public function getWithActiveChild($request);

    public function detectArea(?int $pickup_coverage_id = null, ?int $destination_coverage_id = null);
}
