<?php

namespace Modules\Faq\Repositories;

interface FaqInterface
{

    public function all(string $orderBy = 'id', string $sortBy = 'desc');
    public function activeFaq();
    public function find($id);
    public function store($request);
    public function update($request, $id);
    public function destroy($id);
    public function statusUpdate($id);
}
