<?php

namespace App\Repositories\Account;

interface AccountInterface
{

    public function all($orderBy = 'id', $sortBy = 'desc');
    public function getAll($orderBy = 'id', $sortBy = 'desc');
    public function get($request);
    public function filter($request);
    public function store($request);
    public function update($id, $request);
    public function delete($id);
    public function users();
    public function currentBalance($data);
    public function userAccount($id);
    public function getHubAccounts($hub_id = null);
    public function getAdminAccounts();
    public function getAccounts($request);
}
