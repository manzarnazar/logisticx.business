<?php

namespace App\Repositories\Department;

interface DepartmentInterface
{

    public function all(string $orderBy = 'id', string $sortBy = 'desc');
    public function get($id);
    public function store($request);
    public function update($request);
    public function delete($id);
    public function activeDepartments();
}
