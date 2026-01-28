<?php

namespace App\Repositories\Role;

interface RoleInterface
{

    public function all(string $orderBy = 'id', string $sortBy = 'desc');

    public function getRole(string $orderBy = 'id', string $sortBy = 'desc');

    public function get($id);

    public function store($request);

    public function update($request);

    public function delete($id);

    public function permissions($role);
}
