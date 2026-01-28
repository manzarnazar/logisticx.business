<?php

namespace App\Repositories\ContactUs;


interface ContactUsInterface
{

    public function all(int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc');
    public function storeMessage($request);
}
