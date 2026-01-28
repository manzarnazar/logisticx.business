<?php

namespace App\Repositories\BankTransaction;

interface BankTransactionInterface
{

    public function all(string $orderBy = 'id', string $sortBy = 'desc');
    public function filter($request, string $orderBy = 'created_at');
}
