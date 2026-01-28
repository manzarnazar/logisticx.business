<?php

namespace App\Repositories\CustomerInquiry;

interface CustomerInquiryInterface
{

    public function all(string $orderBy = 'id', string $sortBy = 'desc');
    public function get($id);
    public function find($id);
    public function store($request);
    public function delete($id);
}
