<?php

namespace App\Repositories\Income;

interface IncomeInterface
{
    public function all(string $orderBy = 'id', string $sortBy = 'desc');
    public function filter($request, string $orderBy = 'id', string $sortBy = 'desc');
    public function accountHeads(string $orderBy = 'id', string $sortBy = 'asc');
    public function hubCheck($request);
    public function hubUsers($id);
    public function hubUserAccounts($request);
    public function get($id);
    public function store($data);
    public function update($request);
    public function delete($id);
}
