<?php

namespace Modules\Features\Repositories\Features;


interface FeaturesInterface
{

    public function all(string $orderBy = 'id', string $sortBy = 'desc');
    public function get(string $orderBy = 'id', string $sortBy = 'desc');
    public function getFind($id);
    public function store($request);
    public function update($request, $id);
    public function delete($id);
    public function statusUpdate($id);
}
