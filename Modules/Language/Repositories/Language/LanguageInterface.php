<?php

namespace Modules\Language\Repositories\Language;

interface LanguageInterface
{
    public function flags();

    public function all(int $status = null, int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc');

    public function get($id);

    public function store($request);

    public function update($request);

    public function editPhrase($id);

    public function updatePhrase($request, $code);

    public function delete($id);
}
