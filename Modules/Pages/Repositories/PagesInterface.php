<?php

namespace Modules\Pages\Repositories;

interface PagesInterface
{
    public function all(string $orderBy = 'id', string $sortBy = 'desc');

    public function get($id);

    public function update($request, $id);

    public function pageDetails($page_slug);

    public function page($page);
}
