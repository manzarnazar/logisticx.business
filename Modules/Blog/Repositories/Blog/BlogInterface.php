<?php

namespace Modules\Blog\Repositories\Blog;

interface BlogInterface
{
    public function all(bool $status = null, $search = null, int $paginate = null, string $orderBy = 'id', $sortBy = 'desc');

    public function get();

    public function getFind($id);

    public function findBySlug($slug);

    public function store($request);

    public function update($request, $id);

    public function delete($id);

    public function statusUpdate($id);
}
