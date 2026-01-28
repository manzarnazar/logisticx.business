<?php

namespace App\Repositories\Designation;

interface DesignationInterface
{

    public function all(string $orderBy = 'id', string $sortBy = 'desc');

    public function activeDesignations();

    public function get($id);

    public function store($request);

    public function update($request);

    public function delete($id);
}
