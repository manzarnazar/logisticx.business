<?php

namespace App\Repositories\ServiceFaq;


interface ServiceFaqInterface
{
    public function all(int $status = null, array $column = [], int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc');

    public function get($id);

    public function store($request);

    public function update($request);

    public function delete($id);
}
