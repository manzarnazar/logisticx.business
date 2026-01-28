<?php

namespace App\Repositories\Profile;

interface ProfileInterface
{

    public function get($id);
    public function update($request);
    public function passwordUpdate($request);
}
