<?php

namespace App\Repositories\Expense;

interface ExpenseInterface
{

    public function all(string $orderBy = 'id', string $sortBy = 'desc');
    public function filter($request, string $orderBy = 'id', string $sortBy = 'desc');
    public function get($id);
    public function store($data);
    public function update($data);
    public function delete($id);
}
