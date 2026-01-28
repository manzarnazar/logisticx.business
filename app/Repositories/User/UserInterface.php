<?php

namespace App\Repositories\User;

interface UserInterface
{

    public function all(bool $status = null, $userType = null, string $orderBy = 'id', string $sortBy = 'desc', int $paginate = null);
    public function allGet();
    public function hubs();
    public function departments();
    public function designations();
    public function get($id);
    public function filter($request);
    public function store($request);
    public function update($request);
    public function delete($id);
    public function permissionUpdate($id, $request);

    public function getWithFilter(array $where = [], array $columns = ['*'],  int $paginate = null);

    public function cookieConsent($request);
}
