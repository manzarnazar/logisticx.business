<?php

namespace App\Repositories\ProductCategory;


interface ProductCategoryInterface
{
    public function all(int $status = null, array $column = [], int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc');

    public function single($id);

    public function store($request);

    public function update($request);

    public function delete($id);
}
