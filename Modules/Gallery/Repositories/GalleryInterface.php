<?php

namespace Modules\Gallery\Repositories;

interface GalleryInterface
{
    public function all(bool $status = null, $search = null, int $paginate = null, string $orderBy = 'id', $sortBy = 'desc');

    public function get();

    public function getFind($id);

    public function store($request);

    public function update($request, $id);

    public function delete($id);
}
