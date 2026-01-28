<?php

namespace App\Repositories\Support;

interface SupportInterface
{

    public function all(string $orderBy = 'id', string $sortBy = 'desc');
    public function departments();
    public function get($id);
    public function chats($id);
    public function store($request);
    public function reply($request);
    public function update($id, $request);
    public function delete($id);
}
