<?php

namespace App\Repositories\Salary;

interface SalaryInterface
{
    public function salaryFilter($request);

    public function all(int $status = null, int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc');
    public function get($salary_generate_id);
    public function autogenerate($request);
    public function store($request);
    public function update($request);
    public function delete($id);

    public function pay($request);
    public function reverseSalaryPay($request);
}
