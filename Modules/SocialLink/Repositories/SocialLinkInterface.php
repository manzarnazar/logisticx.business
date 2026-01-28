<?php

namespace Modules\SocialLink\Repositories;

interface SocialLinkInterface
{
    public function get(string $orderBy = 'id', string $sortBy = 'desc');
    public function getActiveAll();
    public function getFind($id);
    public function store($request);
    public function update($request, $id);
    public function delete($id);
    public function statusUpdate($id);
}
